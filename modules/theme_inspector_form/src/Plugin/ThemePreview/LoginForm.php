<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

use Drupal\Core\Form\FormBuilderInterface;
use Drupal\theme_inspector\ThemePreviewPluginBase;
use Drupal\user\Form\UserLoginForm;

/**
 * Login form preview.
 *
 * @ThemePreview(
 *   id = "login_form",
 *   label = @Translation("Login Form"),
 *   category = @Translation("Form Examples"),
 * )
 */
final class LoginForm extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    return self::getFormBuilder()->getForm(UserLoginForm::class);
  }

  private static function getFormBuilder(): FormBuilderInterface {
    return \Drupal::formBuilder();
  }

}
