((behaviors, once) => {

  'use strict';

  Drupal.behaviors.themeInspectorCommonProgressBar = {
    attach (context, settings) {
      const progressBarWrapper = once('ti-progress-bar', '[data-ti-progress-bar]', context).shift();
      if (!progressBarWrapper) {
        return;
      }

      const timeout = settings.themeInspector.progressBarTimeout;
      function updateCallback(progress, status, pb) {
        if (progress < 100) {
          let newProgress = Math.min(100, progress + Math.ceil(10 * Math.random()));
          let message = Math.random().toString(36).substr(2, 5);
          setTimeout(() => pb.setProgress(newProgress, message), timeout);
        }
      }

      const progressBar = new Drupal.ProgressBar('ti-progress-bar-demo', updateCallback);
      progressBar.setProgress(-1, 'Initial message');
      progressBarWrapper.append(progressBar.element.get(0));

    }
  };

}) (Drupal, window.once);
