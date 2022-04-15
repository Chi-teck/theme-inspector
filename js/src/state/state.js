export default class State {
  #activePreview;
  #debugOverlay;
  #code;
  #outline;
  #editable;
  #auth;
  #fullscreen;
  #zoom;

  constructor(activePreview, fullscreen, zoom) {
    this.#activePreview = activePreview;
    this.#fullscreen = fullscreen;
    this.#zoom = zoom;

    function Toggler() {
      const subscribers = [];
      let isActive = false;

      this.subscribe = sb => subscribers.push(sb);

      Object.defineProperty(
        this,
        'isActive',
        { get: () => isActive },
      );

      this.toggle = force => {
        const wasActive = isActive;
        isActive = force ?? !isActive;
        if (wasActive !== isActive) {
          subscribers.forEach(sb => sb(isActive));
        }
        return isActive;
      };
    }

    this.#debugOverlay = new Toggler();
    this.#code = new Toggler();
    this.#outline = new Toggler();
    this.#editable = new Toggler();
    this.#auth = new Toggler();
  }

  get activePreview() {
    return this.#activePreview;
  }

  get fullscreen() {
    return this.#fullscreen;
  }

  get debugOverlay() {
    return this.#debugOverlay;
  }

  get outline() {
    return this.#outline;
  }

  get code() {
    return this.#code;
  }

  get editable() {
    return this.#editable;
  }

  get auth() {
    return this.#auth;
  }

  get zoom() {
    return this.#zoom;
  }
}
