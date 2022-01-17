<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * A preview  plugin for status messages.
 *
 * @ThemePreview(
 *   id = "status_messages",
 *   label = @Translation("Status messages"),
 *   category = @Translation("Common"),
 *   variations = {
 *     "short" = @Translation("Short message"),
 *     "long" = @Translation("Long message"),
 *     "multiple" = @Translation("Multiple messages"),
 *   },
 * )
 */
final class StatusMessages extends ThemePreviewPluginBase {

  use StringTranslationTrait;

  public function build(string $variation): array {

    $messages = match ($variation) {
      'short' => [$this->random()->sentences(5)],
      'long' => [
        new FormattableMarkup(<<< 'HTML'
          <p>Lorem ipsum <a href=":url">dolor</a> sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Volutpat blandit aliquam etiam erat velit. Mattis rhoncus urna neque viverra justo nec ultrices dui sapien.
            Nunc scelerisque viverra mauris in aliquam sem fringilla ut.
            Molestie ac feugiat sed lectus vestibulum mattis ullamcorper. Tempor id eu nisl nunc mi ipsum faucibus.</p>
          <p>Enim ut <b>tellus</b> elementum <em>sagittis</em> vitae. Egestas erat imperdiet sed euismod nisi porta lorem mollis aliquam.
            Non odio euismod lacinia at quis risus. Sed libero enim sed faucibus. Velit ut tortor pretium viverra suspendisse potenti nullam ac tortor.</p>
          <p>Quam id leo in vitae turpis. Molestie ac feugiat sed lectus vestibulum mattis ullamcorper velit. Faucibus vitae aliquet nec ullamcorper.</p>
          HTML,
          [':url' => 'https://example.com'],
        ),
      ],
      'multiple' => [
        'First message.',
        'Second message.',
        'Long third message. ' . $this->random()->paragraphs(1),
      ],
    };

    return self::buildMessages($messages);
  }

  private static function buildMessages(array $messages): array {
    $message_types = ['status', 'warning', 'error'];
    foreach ($message_types as $type) {
      $messages_list[$type] = $messages;
    }
    return [
      'content' => [
        '#theme' => 'status_messages',
        '#message_list' => $messages_list,
        '#status_headings' => [
          'status' => t('Status message'),
          'error' => t('Error message'),
          'warning' => t('Warning message'),
        ],
      ],
    ];
  }

}
