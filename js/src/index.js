import Toolbar from './toolbar';
import Sidebar from './sidebar';
import Preview from './preview';
import Fullscreen from './state/fullscreen';
import State from './state/state';
import Zoom from './state/zoom';
import ActivePreview from './state/active-preview';
import { ErrorHandler } from './error';

window.Drupal.behaviors.themeInspector = {
  attach(context, settings) {
    const [$app] = window.once('theme-inspector', '[data-ti-app]', context);
    if (!$app) {
      return;
    }

    window.addEventListener('error', new ErrorHandler($app, Drupal.Message));

    const el = component => $app.querySelector(`[data-ti-${component}]`);

    const config = settings.themeInspector;

    const activePreview = new ActivePreview(config);
    const state = new State(
      activePreview,
      new Fullscreen(el('main-content')),
      new Zoom(),
    );

    Toolbar(el('toolbar'), state, config);
    Sidebar(el('sidebar'), state);
    Preview(el('preview'), state);

    window.addEventListener('popstate', () => { activePreview.loadFromUrl(); });
    activePreview.loadFromUrl();
    context.querySelector('[data-ti-cloak]').removeAttribute('data-ti-cloak');
  },
};
