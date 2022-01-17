(function(){'use strict';function ZoomWidget($element, state) {
  const $outButton = $element.querySelector('[data-ti-zoom-out]');
  const $inButton = $element.querySelector('[data-ti-zoom-in]');
  const $output = $element.querySelector('[data-ti-zoom]');
  const { zoom } = state;

  const buttonHandler = method => {
    zoom[method]();
    $outButton.disabled = zoom.isMin;
    $inButton.disabled = zoom.isMax;
  };

  $outButton.addEventListener('click', () => { buttonHandler('out'); });
  $inButton.addEventListener('click', () => { buttonHandler('in'); });
  zoom.subscribe(value => { $output.innerHTML = value + '%'; });
}function Toolbar($element, state) {
  const $variationList = $element.querySelector('[data-ti-toolbar-variation-list]');

  ZoomWidget($element.querySelector('[data-ti-zoom-widget]'), state);

  function button(name) {
    button.buttons ??= {};
    button.buttons[name] ??= $element.querySelector(`[data-ti-toolbar-button="${name}"]`);
    return button.buttons[name];
  }

  function toggleHandler(name) {
    return isActive => {
      button(name).toggleAttribute('data-ti-pressed', isActive);
      button(name).setAttribute('aria-pressed', isActive ? 'true' : 'false');
    };
  }

  function enableAll(status) {
    $element.querySelectorAll('button').forEach($button => { $button.disabled = !status; });
    $variationList.disabled = !status;
    $element.toggleAttribute('ti-data-disabled', !status);
  }

  state.fullscreen.subscribe(toggleHandler('fullscreen'));
  state.debugOverlay.subscribe(toggleHandler('debug-overlay'));
  state.outline.subscribe(toggleHandler('outline'));
  state.code.subscribe(toggleHandler('code'));
  state.editable.subscribe(toggleHandler('editable'));
  state.auth.subscribe(toggleHandler('auth'));

  if (!state.activePreview.id) {
    enableAll(false);
  }

  if (!state.fullscreen.isSupported) {
    button('fullscreen').hidden = true;
  }

  button('reload').addEventListener('click', () => state.activePreview.reload());
  button('new-window').addEventListener('click', () => window.open(state.activePreview.getUrl(state.auth.isActive)));
  button('fullscreen').addEventListener('click', () => state.fullscreen.toggle());
  button('debug-overlay').addEventListener('click', () => state.debugOverlay.toggle());
  button('code').addEventListener('click', () => state.code.toggle());
  button('outline').addEventListener('click', () => state.outline.toggle());
  button('editable').addEventListener('click', () => state.editable.toggle());
  button('auth').addEventListener('click', () => state.auth.toggle());

  document.addEventListener('keydown', event => {
    if (event.key === 'F5') {
      event.preventDefault();
      state.activePreview.reload();
    }
  });

  state.activePreview.subscribe(activePreview => {
    if (activePreview.id) {
      enableAll(true);
    }
    $variationList.length = 0;
    // eslint-disable-next-line no-restricted-syntax
    for (const [id, variation] of Object.entries(activePreview.definition.variations)) {
      $variationList.add(
        new window.Option(variation.label, id, false, id === activePreview.variation),
      );
    }
    $variationList.disabled = $variationList.length === 1;
  });

  $variationList.addEventListener(
    'change',
    () => state.activePreview.update(state.activePreview.id, $variationList.value),
  );
}function Sidebar($element, state) {
  const $searchInput = $element.querySelector('[data-ti-search-input]');
  const groups = $element.querySelectorAll('[data-ti-group]');
  const links = $element.querySelectorAll('[data-ti-preview-link]');

  state.activePreview.subscribe(
    activePreview => {
      links.forEach(link => {
        const isActive = new window.URL(link.href).searchParams.get('preview') === activePreview.id;
        link.setAttribute('aria-current', isActive ? 'true' : 'false');
        link.toggleAttribute('data-ti-active', isActive);
      });
    },
  );

  const linkHandler = event => {
    event.preventDefault();
    const params = new window.URL(event.target.href).searchParams;
    state.activePreview.update(params.get('preview'), params.get('variation'));
  };

  links.forEach(link => link.addEventListener('click', linkHandler));

  $searchInput.addEventListener('input', () => {
    const input = $searchInput.value.toLowerCase();
    links.forEach(
      link => { link.parentElement.hidden = !link.innerHTML.toLowerCase().includes(input); },
    );
    groups.forEach(
      group => {
        const total = group.querySelectorAll('li:not([hidden])').length;
        group.querySelector('[data-ti-group-counter]').innerHTML = total;
        group.hidden = total === 0;
      },
    );
  });
}function Preview($element, state) {
  const $iframe = $element.querySelector('[data-ti-preview] iframe');

  function loadDocument() {
    $element.setAttribute('data-ti-preview-loading', '');
    $iframe.removeAttribute('srcdoc');
    $iframe.src = state.activePreview.getUrl(state.auth.isActive);
  }

  function debugOverlayHandler(status) {
    $iframe
      .contentDocument
      .getElementById('ti-preview')
      .classList.toggle('ti-debug-overlay', status);
  }

  function codeHandler(status) {
    const $preview = $iframe.contentDocument.getElementById('ti-preview');
    const $code = $iframe.contentDocument.getElementById('ti-code');
    if (status) {
      $preview.hidden = true;
      $code.innerHTML = $iframe.contentWindow.Prism.highlight(
        $preview.innerHTML,
        $iframe.contentWindow.Prism.languages.html,
        'html',
      );
      $code.hidden = false;
    }
    else {
      $code.hidden = true;
      $preview.hidden = false;
    }
  }

  function outlineHandler(status) {
    $iframe
      .contentDocument
      .getElementById('ti-preview')
      .classList.toggle('ti-outline', status);
  }

  function editableHandler(status) {
    $iframe
      .contentDocument
      .getElementById('ti-preview')
      .toggleAttribute('contenteditable', status);
  }

  function zoomHandler(value) {
    $iframe
      .contentDocument
      .getElementById('ti-preview')
      .style
      .setProperty('--ti-zoom-scale', (value / 100).toString());
  }

  $iframe.addEventListener('load', () => {
    if ($iframe.getAttribute('srcdoc') === null) {
      debugOverlayHandler(state.debugOverlay.isActive);
      codeHandler(state.code.isActive);
      editableHandler(state.editable.isActive);
      outlineHandler(state.outline.isActive);
      zoomHandler(state.zoom.value);
    }
    $element.removeAttribute('data-ti-preview-loading');
  });

  state.debugOverlay.subscribe(debugOverlayHandler);
  state.code.subscribe(codeHandler);
  state.outline.subscribe(outlineHandler);
  state.editable.subscribe(editableHandler);
  state.auth.subscribe(loadDocument);
  state.activePreview.subscribe(loadDocument);
  state.zoom.subscribe(zoomHandler);
}function Fullscreen($element) {
  const subscribers = [];
  const isSupported = document.fullscreenEnabled;

  Object.defineProperty(
    this,
    'isSupported',
    { value: isSupported, writable: false },
  );

  if (this.isSupported) {
    document.addEventListener('keydown', event => {
      if (event.key === 'F11') {
        event.preventDefault();
        this.toggle();
      }
    });

    $element.addEventListener(
      'fullscreenchange',
      () => {
        const { isActive } = this;
        subscribers.forEach(sb => sb(isActive));
        $element.toggleAttribute('data-ti-fullscreen', isActive);
      },
    );
  }

  this.subscribe = sb => subscribers.push(sb);

  this.on = () => $element.requestFullscreen();

  this.off = () => document.exitFullscreen();

  this.toggle = () => this[this.isActive ? 'off' : 'on']();

  Object.defineProperty(
    this,
    'isActive',
    { get: () => $element === document.fullscreenElement },
  );
}function History(state) {
  state.activePreview.subscribe(
    activePreview => {
      const params = new window.URLSearchParams(
        { preview: activePreview.id, variation: activePreview.variation },
      );
      window.history.pushState({}, '', '?' + params.toString());
    },
  );
}class State {
  #activePreview;
  #debugOverlay;
  #code;
  #outline;
  #editable;
  #auth;
  #fullscreen;
  #zoom;

  constructor(activePreview, fullscreen, zoom) {
    this.#activePreview = activePreview;
    this.#fullscreen = fullscreen;
    this.#zoom = zoom;

    function Toggler() {
      const subscribers = [];
      let isActive = false;

      this.subscribe = sb => subscribers.push(sb);

      Object.defineProperty(
        this,
        'isActive',
        { get: () => isActive },
      );

      this.toggle = force => {
        const wasActive = isActive;
        isActive = force ?? !isActive;
        if (wasActive !== isActive) {
          subscribers.forEach(sb => sb(isActive));
        }
        return isActive;
      };
    }

    this.#debugOverlay = new Toggler();
    this.#code = new Toggler();
    this.#outline = new Toggler();
    this.#editable = new Toggler();
    this.#auth = new Toggler();
  }

  get activePreview() {
    return this.#activePreview;
  }

  get fullscreen() {
    return this.#fullscreen;
  }

  get debugOverlay() {
    return this.#debugOverlay;
  }

  get outline() {
    return this.#outline;
  }

  get code() {
    return this.#code;
  }

  get editable() {
    return this.#editable;
  }

  get auth() {
    return this.#auth;
  }

  get zoom() {
    return this.#zoom;
  }
}function Zoom() {
  const subscribers = [];

  this.subscribe = sb => subscribers.push(sb);
  const dispatch = () => subscribers.forEach(sb => sb(this.value));

  let steps = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150, 175];
  steps = steps.concat([200, 225, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900]);

  let step = steps.indexOf(100);

  this.in = () => {
    step++;
    dispatch();
  };

  this.out = () => {
    step--;
    dispatch();
  };

  Object.defineProperty(this, 'value', { get: () => steps[step] });
  Object.defineProperty(this, 'isMin', { get: () => step === 0 });
  Object.defineProperty(this, 'isMax', { get: () => step === steps.length - 1 });
}class ThemeInspectorError extends Error {}

function ErrorHandler($app, Message) {
  return event => {
    if (event.error instanceof ThemeInspectorError) {
      new Message().add(event.message, { type: 'error' });
      $app.remove();
    }
  };
}class ActivePreview {
  #previews;
  #id;
  #variation;
  #subscribers = [];

  constructor(config) {
    this.#previews = config.previews;
    this.#subscribers = [];
  }

  subscribe(sb) {
    this.#subscribers.push(sb);
  }

  update(id, variation) {
    this.#id = id;
    this.#variation = variation;

    const previews = this.#previews;

    if (previews[this.#id] === undefined) {
      throw new ThemeInspectorError(`Preview "${this.#id}" does not exist.`);
    }
    if (previews[this.#id].variations[this.#variation] === undefined) {
      throw new ThemeInspectorError(`Variation "${this.#variation}" does not exist.`);
    }
    this.reload();
  }

  reload() {
    this.#subscribers.forEach(sb => sb(this));
  }

  get id() {
    return this.#id;
  }

  get variation() {
    return this.#variation;
  }

  get definition() {
    return this.#previews[this.#id];
  }

  getUrl(auth) {
    return this.#previews[this.id].variations[this.variation].url + '&auth=' + (auth ? '1' : '0');
  }
}window.Drupal.behaviors.themeInspector = {
  attach(context, settings) {
    const $app = context.querySelector('[data-ti-app]');
    window.addEventListener('error', new ErrorHandler($app, Drupal.Message));

    const el = component => $app.querySelector(`[data-ti-${component}]`);

    const config = settings.themeInspector;

    const state = new State(
      new ActivePreview(config),
      new Fullscreen(el('main-content')),
      new Zoom(),
    );

    Toolbar(el('toolbar'), state);
    Sidebar(el('sidebar'), state);
    Preview(el('preview'), state);
    History(state);

    const urlSearchParams = new window.URLSearchParams(window.location.search);
    if (urlSearchParams.has('preview') && urlSearchParams.has('variation')) {
      state.activePreview.update(urlSearchParams.get('preview'), urlSearchParams.get('variation'));
    }

    context.querySelector('[data-ti-cloak]').removeAttribute('data-ti-cloak');
  },
};})();