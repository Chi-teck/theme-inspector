<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Example;

use Drupal\Core\Form\FormBuilderInterface;
use Drupal\theme_inspector\ThemePreviewPluginBase;
use Drupal\user\Form\UserPasswordForm;

/**
 * Password form preview.
 *
 * @ThemePreview(
 *   id = "password_form",
 *   label = @Translation("Password Form"),
 *   category = @Translation("Form Examples"),
 * )
 */
final class PasswordForm extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    return self::getFormBuilder()->getForm(UserPasswordForm::class);
  }

  private static function getFormBuilder(): FormBuilderInterface {
    return \Drupal::formBuilder();
  }

}
