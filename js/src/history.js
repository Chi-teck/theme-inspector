export default function History(state) {
  state.activePreview.subscribe(
    activePreview => {
      const params = new window.URLSearchParams(
        { preview: activePreview.id, variation: activePreview.variation },
      );
      window.history.pushState({}, '', '?' + params.toString());
    },
  );
}
