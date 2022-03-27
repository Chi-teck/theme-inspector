<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Element;

/**
 * Date list input preview.
 *
 * @ThemePreview(
 *   id = "datelist",
 *   label = @Translation("Date list"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "with_time" = @Translation("With time"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class Datelist extends FormElementBase {

  protected function getElement(string $variation): array {
    $data_part_order = ['year', 'month', 'day'];
    if ($variation === 'with_time') {
      $data_part_order = \array_merge($data_part_order, ['hour', 'minute']);
    }
    return [
      '#title' => $this->random()->title(),
      '#type' => 'datelist',
      '#description' => $this->random()->sentences(1),
      '#disabled' => $variation === 'disabled',
      '#date_part_order' => $data_part_order,
    ];
  }

}
