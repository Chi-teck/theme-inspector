import { ThemeInspectorError } from '../error';

export default class ActivePreview {
  #previews;
  #loadPrevious;
  #id;
  #variation;
  #subscribers = [];

  constructor(config) {
    this.#previews = config.previews;
    this.#loadPrevious = config.loadPrevious;
  }

  loadFromUrl() {
    const urlSearchParams = new window.URLSearchParams(window.location.search);
    if (urlSearchParams.has('preview') && urlSearchParams.has('variation')) {
      this.update(urlSearchParams.get('preview'), urlSearchParams.get('variation'));
    }
    else {
      this.#loadFromCookie();
    }
  }

  reload() {
    this.update(this.id, this.variation);
  }

  subscribe(sb) {
    this.#subscribers.push(sb);
  }

  update(id, variation, push = false) {
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

    const record = { preview: id, variation };
    const url = '?' + new window.URLSearchParams(record).toString();

    if (push) {
      window.history.pushState({}, '', url);
    }

    window.Cookies.set('ti-last-preview', id);
    window.Cookies.set('ti-last-variation', variation);
    this.dispatch();
  }

  dispatch() {
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

  #loadFromCookie() {
    if (!this.#loadPrevious) {
      return;
    }

    const preview = window.Cookies.get('ti-last-preview');
    const variation = window.Cookies.get('ti-last-variation');

    if (preview && variation) {
      // Previews might be theme specific.
      const isExists = this.#previews[preview]?.variations[variation] !== undefined;
      if (isExists) {
        this.update(preview, variation, true);
      }
    }
  }
}
