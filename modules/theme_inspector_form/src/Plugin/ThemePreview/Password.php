<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

/**
 * Password input preview.
 *
 * @ThemePreview(
 *   id = "password",
 *   label = @Translation("Password"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "simple" = @Translation("Simple"),
 *     "with_confirmation" = @Translation("With confirmation"),
 *   },
 * )
 */
final class Password extends FormElementBase {

  protected function getElement(string $variation): array {
    return [
      '#type' => $variation === 'simple' ? 'password' : 'password_confirm',
      '#title' => $this->random()->title(),
      '#size' => 25,
      '#pattern' => '[01]+',
      '#description' => $this->random()->sentences(1),
    ];
  }

}
