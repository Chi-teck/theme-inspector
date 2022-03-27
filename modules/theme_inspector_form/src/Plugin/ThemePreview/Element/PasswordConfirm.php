<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Element;

/**
 * Password confirm preview.
 *
 * @ThemePreview(
 *   id = "password_confirm",
 *   label = @Translation("Password confirm"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class PasswordConfirm extends FormElementBase {

  protected function getElement(string $variation): array {
    return [
      '#type' => 'password_confirm',
      '#title' => $this->random()->title(),
      '#size' => 25,
      '#description' => $this->random()->sentences(1),
      '#disabled' => $variation === 'disabled',
    ];
  }

}
