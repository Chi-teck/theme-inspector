export default function Sidebar($element, state) {
  const $searchInput = $element.querySelector('[data-ti-search-input]');
  const groups = $element.querySelectorAll('[data-ti-group]');
  const links = $element.querySelectorAll('[data-ti-preview-link]');

  state.activePreview.subscribe(
    activePreview => {
      links.forEach(link => {
        const isActive = new window.URL(link.href).searchParams.get('preview') === activePreview.id;
        link.setAttribute('aria-current', isActive ? 'true' : 'false');
        link.toggleAttribute('data-ti-active', isActive);
      });
    },
  );

  const linkHandler = event => {
    event.preventDefault();
    const params = new window.URL(event.target.href).searchParams;
    state.activePreview.update(params.get('preview'), params.get('variation'), true);
  };

  links.forEach(link => link.addEventListener('click', linkHandler));

  $searchInput.addEventListener('input', () => {
    const input = $searchInput.value.toLowerCase();
    links.forEach(
      link => { link.parentElement.hidden = !link.innerHTML.toLowerCase().includes(input); },
    );
    groups.forEach(
      group => {
        const total = group.querySelectorAll('li:not([hidden])').length;
        group.querySelector('[data-ti-group-counter]').innerHTML = total;
        group.hidden = total === 0;
      },
    );
  });
}
