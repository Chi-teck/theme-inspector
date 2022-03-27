<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Element;

/**
 * Password input preview.
 *
 * @ThemePreview(
 *   id = "password",
 *   label = @Translation("Password"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class Password extends FormElementBase {

  protected function getElement(string $variation): array {
    return [
      '#type' => 'password',
      '#title' => $this->random()->title(),
      '#size' => 25,
      '#pattern' => '[01]+',
      '#description' => $this->random()->sentences(1),
      '#disabled' => $variation === 'disabled',
    ];
  }

}
