export default function Sidebar($element, state) {
  const $searchInput = $element.querySelector('[data-ti-search-input]');
  const headers = $element.querySelectorAll('[data-ti-category-header]');
  const links = $element.querySelectorAll('a[data-ti-preview-link]');

  state.activePreview.subscribe(
    activePreview => {
      links.forEach(link => {
        const isActive = new window.URL(link.href).searchParams.get('preview') === activePreview.id;
        link.setAttribute('aria-current', isActive ? 'true' : 'false');
        link.classList.toggle('js-ti-active', isActive);
      });
    },
  );

  const linkHandler = event => {
    event.preventDefault();
    const params = new window.URL(event.target.href).searchParams;
    state.activePreview.update(params.get('preview'), params.get('variation'));
  };

  links.forEach(link => link.addEventListener('click', linkHandler));

  $searchInput.addEventListener('input', () => {
    const input = $searchInput.value.toLowerCase();
    links.forEach(
      link => { link.parentElement.hidden = !link.innerHTML.toLowerCase().includes(input); },
    );
    headers.forEach(
      header => { header.hidden = !header.nextElementSibling.querySelector('li:not([hidden])'); },
    );
  });
}
