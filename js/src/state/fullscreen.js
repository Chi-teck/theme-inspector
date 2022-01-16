export default function Fullscreen($element) {
  const subscribers = [];
  const isSupported = document.fullscreenEnabled;

  Object.defineProperty(
    this,
    'isSupported',
    { value: isSupported, writable: false },
  );

  if (this.isSupported) {
    document.addEventListener('keydown', event => {
      if (event.key === 'F11') {
        event.preventDefault();
        this.toggle();
      }
    });

    $element.addEventListener(
      'fullscreenchange',
      () => {
        const { isActive } = this;
        subscribers.forEach(sb => sb(isActive));
        $element.toggleAttribute('data-ti-fullscreen', isActive);
      },
    );
  }

  this.subscribe = sb => subscribers.push(sb);

  this.on = () => $element.requestFullscreen();

  this.off = () => document.exitFullscreen();

  this.toggle = () => this[this.isActive ? 'off' : 'on']();

  Object.defineProperty(
    this,
    'isActive',
    { get: () => $element === document.fullscreenElement },
  );
}
