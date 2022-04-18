import ZoomWidget from './zoom-widget';

export default function Toolbar($element, state) {
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
    if (event.key === 'F5' && state.activePreview.id) {
      event.preventDefault();
      state.activePreview.reload();
    }
  });

  state.activePreview.subscribe(activePreview => {
    $variationList.length = 0;
    if (activePreview.id) {
      enableAll(true);
      // eslint-disable-next-line no-restricted-syntax
      for (const [id, variation] of Object.entries(activePreview.definition.variations)) {
        $variationList.add(
          new window.Option(variation.label, id, false, id === activePreview.variation),
        );
      }
    }
    $variationList.disabled = $variationList.length === 1;
  });

  $variationList.addEventListener(
    'change',
    () => state.activePreview.update(state.activePreview.id, $variationList.value),
  );
}
