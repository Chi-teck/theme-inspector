((Drupal => {
  Drupal.behaviors.themeInspectorPreview = {
    attach() {
      // Showing window size only makes sense inside an iframe.
      if (window.frameElement === null) {
        return;
      }
      const $previewSize = document.getElementById('ti-preview-size');
      let timer = null;
      window.addEventListener('resize', () => {
        $previewSize.innerHTML = `${window.innerWidth}px &times; ${window.innerHeight}px`;
        $previewSize.setAttribute('data-ti-resizing', null);
        window.clearTimeout(timer);
        timer = window.setTimeout(() => $previewSize.removeAttribute('data-ti-resizing'), 1000);
      });
    },
  };
})(Drupal));
