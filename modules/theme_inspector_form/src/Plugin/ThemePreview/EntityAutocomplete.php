<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

/**
 * Entity autocomplete preview.
 *
 * @ThemePreview(
 *   id = "entity_autocomplete",
 *   label = @Translation("Entity Autocomplete"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class EntityAutocomplete extends FormElementBase {

  protected function getElement(string $variation_id): array {
    return [
      '#title' => 'Example',
      '#type' => 'entity_autocomplete',
      '#description' => $this->random()->sentences(1),
      '#target_type' => 'user',
      '#tags' => TRUE,
      '#selection_handler' => 'default',
    ];
  }

}
