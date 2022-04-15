import { ThemeInspectorError } from '../error';

export default class Router {
  #previews;
  #id;
  #variation;
  #subscribers = [];

  constructor(config) {
    this.#previews = config.previews;
    this.#subscribers = [];

    window.addEventListener('popstate', () => {

      const urlSearchParams = new window.URLSearchParams(window.location.search);
      if (urlSearchParams.has('preview') && urlSearchParams.has('variation')) {
        this.#id = urlSearchParams.get('preview');
        this.#variation = urlSearchParams.get('variation');
        this.reload();
      }

    });
  }

  subscribe(sb) {
    this.#subscribers.push(sb);
  }

  transitionTo(id, variation) {
    this.#id = id;
    this.#variation = variation;

    if (id !== null) {
      const previews = this.#previews;
      if (previews[this.#id] === undefined) {
        throw new ThemeInspectorError(`Preview "${this.#id}" does not exist.`);
      }
      if (previews[this.#id].variations[this.#variation] === undefined) {
        throw new ThemeInspectorError(`Variation "${this.#variation}" does not exist.`);
      }
    }

    const record = { preview: id, variation: variation }
    const url = '?' + new window.URLSearchParams(record).toString();
    window.history.pushState({}, '', url)

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

  getPreviewUrl(auth) {
    return this.#previews[this.id].variations[this.variation].url + '&auth=' + (auth ? '1' : '0');
  }
}
