<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Element;

/**
 * Email input preview.
 *
 * @ThemePreview(
 *   id = "email",
 *   label = @Translation("Email"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class Email extends FormElementBase {

  protected function getElement(string $variation): array {
    return [
      '#title' => $this->random()->title(),
      '#type' => 'email',
      '#description' => $this->random()->sentences(1),
      '#disabled' => $variation === 'disabled',
    ];
  }

}
