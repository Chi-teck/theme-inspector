<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Example;

use Drupal\Core\Entity\EntityFormBuilderInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * Register form preview.
 *
 * @ThemePreview(
 *   id = "register_form",
 *   label = @Translation("Register Form"),
 *   category = @Translation("Form Examples"),
 * )
 */
final class RegisterForm extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    $user = self::getEntityTypeManager()->getStorage('user')->create();
    return self::getEntityFormBuilder()->getForm($user);
  }

  private static function getEntityFormBuilder(): EntityFormBuilderInterface {
    return \Drupal::service('entity.form_builder');
  }

  private static function getEntityTypeManager(): EntityTypeManagerInterface {
    return \Drupal::entityTypeManager();
  }

}
