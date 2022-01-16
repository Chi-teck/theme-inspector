export default function Preview($element, state) {
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
}
