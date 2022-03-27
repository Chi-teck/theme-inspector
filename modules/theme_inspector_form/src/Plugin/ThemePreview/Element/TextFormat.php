<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Element;

/**
 * Text format preview.
 *
 * @ThemePreview(
 *   id = "text_format",
 *   label = @Translation("Text Format"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class TextFormat extends FormElementBase {

  protected function getElement(string $variation): array {
    return [
      '#type' => 'text_format',
      '#title' => 'Body',
      '#format' => \filter_default_format(),
      '#default_value' => 'The quick brown fox jumped over the lazy dog.',
      '#disabled' => $variation === 'disabled',
    ];
  }

}
