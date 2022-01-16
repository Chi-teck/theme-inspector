export default function ZoomWidget($element, state) {
  const $outButton = $element.querySelector('[data-ti-zoom-out]');
  const $inButton = $element.querySelector('[data-ti-zoom-in]');
  const $output = $element.querySelector('[data-ti-zoom]');
  const { zoom } = state;

  const buttonHandler = method => {
    zoom[method]();
    $outButton.disabled = zoom.isMin;
    $inButton.disabled = zoom.isMax;
  };

  $outButton.addEventListener('click', () => { buttonHandler('out'); });
  $inButton.addEventListener('click', () => { buttonHandler('in'); });
  zoom.subscribe(value => { $output.innerHTML = value + '%'; });
}
