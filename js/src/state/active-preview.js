import { ThemeInspectorError } from '../error';

export default class ActivePreview {
  #previews;
  #id;
  #variation;
  #subscribers = [];

  constructor(config) {
    this.#previews = config.previews;
    this.#subscribers = [];
  }

  subscribe(sb) {
    this.#subscribers.push(sb);
  }

  update(id, variation) {
    this.#id = id;
    this.#variation = variation;

    const previews = this.#previews;

    if (previews[this.#id] === undefined) {
      throw new ThemeInspectorError(`Preview "${this.#id}" does not exist.`);
    }
    if (previews[this.#id].variations[this.#variation] === undefined) {
      throw new ThemeInspectorError(`Variation "${this.#variation}" does not exist.`);
    }
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

  getUrl(auth) {
    return this.#previews[this.id].variations[this.variation].url + '&auth=' + (auth ? '1' : '0');
  }
}
