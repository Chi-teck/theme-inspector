export class ThemeInspectorError extends Error {}

export function ErrorHandler($app, Message) {
  return event => {
    if (event.error instanceof ThemeInspectorError) {
      new Message().add(event.message, { type: 'error' });
      $app.remove();
    }
  };
}
