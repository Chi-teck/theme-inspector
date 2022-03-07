export default function Preview($element, state) {
  const $iframe = $element.querySelector('[data-ti-preview] iframe');

  function getPreviewWrapper() {
    return $iframe.contentDocument.getElementById('ti-preview');
  }

  function loadDocument() {
    $element.setAttribute('data-ti-preview-loading', '');
    $iframe.removeAttribute('srcdoc');
    if (state.activePreview.id) {
      $iframe.src = state.activePreview.getUrl(state.auth.isActive);
    }
  }

  function debugOverlayHandler(status) {
    getPreviewWrapper()?.classList.toggle('ti-debug-overlay', status);
  }

  function codeHandler(status) {
    const $preview = getPreviewWrapper();
    if (!$preview) {
      return;
    }
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
    getPreviewWrapper()?.classList.toggle('ti-outline', status);
  }

  function editableHandler(status) {
    getPreviewWrapper()?.toggleAttribute('contenteditable', status);
  }

  function zoomHandler(value) {
    getPreviewWrapper()?.style.setProperty('--ti-zoom-scale', (value / 100).toString());
  }

  $iframe.addEventListener('load', () => {
    $element.removeAttribute('data-ti-preview-loading');
    if ($iframe.getAttribute('srcdoc') !== null) {
      return;
    }
    if (!getPreviewWrapper()) {
      state.activePreview.update(null, null);
      return;
    }
    debugOverlayHandler(state.debugOverlay.isActive);
    codeHandler(state.code.isActive);
    editableHandler(state.editable.isActive);
    outlineHandler(state.outline.isActive);
    zoomHandler(state.zoom.value);
  });

  state.debugOverlay.subscribe(debugOverlayHandler);
  state.code.subscribe(codeHandler);
  state.outline.subscribe(outlineHandler);
  state.editable.subscribe(editableHandler);
  state.auth.subscribe(loadDocument);
  state.activePreview.subscribe(loadDocument);
  state.zoom.subscribe(zoomHandler);
}
