export default class State {
  #router;
  #debugOverlay;
  #code;
  #outline;
  #editable;
  #auth;
  #fullscreen;
  #zoom;

  constructor(router, fullscreen, zoom) {
    this.#router = router;
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
    console.warn('activePreview is deprecated');
    return this.#router;
  }

  get router() {
    return this.#router;
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
