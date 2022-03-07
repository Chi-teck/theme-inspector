<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * Username preview.
 *
 * @ThemePreview(
 *   id = "username",
 *   label = @Translation("Username"),
 *   category = @Translation("Miscellaneous"),
 * )
 */
final class Username extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    return [
      '#theme' => 'username',
      '#account' => self::getCurrentUser(),
    ];
  }

  private static function getCurrentUser(): AccountProxyInterface {
    return \Drupal::currentUser();
  }

}
