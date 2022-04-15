import Toolbar from './toolbar';
import Sidebar from './sidebar';
import Preview from './preview';
import Fullscreen from './state/fullscreen';
// import History from './history';
import State from './state/state';
import Zoom from './state/zoom';
import Router from './state/router';
import { ErrorHandler } from './error';

window.Drupal.behaviors.themeInspector = {
  attach(context, settings) {

    const [$app] = once('theme-inspector', '[data-ti-app]', context);
    if (!$app) {
      return;
    }

    window.addEventListener('error', new ErrorHandler($app, Drupal.Message));

    const el = component => $app.querySelector(`[data-ti-${component}]`);

    const config = settings.themeInspector;

    const state = new State(
      new Router(config),
      new Fullscreen(el('main-content')),
      new Zoom(),
    );

    Toolbar(el('toolbar'), state, config);
    Sidebar(el('sidebar'), state);
    Preview(el('preview'), state);
    // History(state);

    const urlSearchParams = new window.URLSearchParams(window.location.search);
    if (urlSearchParams.has('preview') && urlSearchParams.has('variation')) {
      state.router.transitionTo(urlSearchParams.get('preview'), urlSearchParams.get('variation'));
    }

    context.querySelector('[data-ti-cloak]').removeAttribute('data-ti-cloak');
  },
};
