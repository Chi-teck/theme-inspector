export default function Preview($element, state) {
  const $iframe = $element.querySelector('[data-ti-preview] iframe');

  function getPreviewWrapper() {
    return $iframe.contentDocument.getElementById('ti-preview');
  }

  let loading = false;

  function loadDocument() {
    $iframe.removeAttribute('srcdoc');
    if (state.activePreview.id) {
      $element.setAttribute('data-ti-preview-loading', '');
      loading = true;
      // Use location replace instead of modifying iframe src to avoid duplicated
      // entries in the history.
      // @see https://stackoverflow.com/a/8681618/272927
      $iframe.contentWindow.location.replace(state.activePreview.getUrl(state.auth.isActive));
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
    loading = false;

    // Stop a user from loading URLs that are not part of the preview by clicking links and
    // submitting forms in the inner document.
    const stopLoading = () => { loading || $iframe.contentWindow.stop(); };
    $iframe.contentWindow.addEventListener('beforeunload', () => { setTimeout(stopLoading, 0); });

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
