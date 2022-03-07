export default function History(state) {
  state.activePreview.subscribe(
    activePreview => {
      let url = '';
      if (activePreview.id) {
        const record = { preview: activePreview.id, variation: activePreview.variation };
        url = '?' + new window.URLSearchParams(record).toString();
      }
      window.history.pushState({}, '', url);
    },
  );
}
