<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview\Element;

/**
 * Machine name input preview.
 *
 * @ThemePreview(
 *   id = "machine_name",
 *   label = @Translation("Machine name"),
 *   category = @Translation("Form Elements"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "disabled" = @Translation("Disabled"),
 *   },
 * )
 */
final class MachineName extends FormElementBase {

  protected function getElement(string $variation): array {

    $element['label'] = [
      '#type' => 'textfield',
      '#title' => 'Name',
      '#description' => 'Project name.',
      '#disabled' => $variation === 'disabled',
      '#default_value' => 'Example',
    ];
    $element['id'] = [
      '#title' => 'Machine name',
      '#type' => 'machine_name',
      '#description' => 'Project machine name',
      '#disabled' => $variation === 'disabled',
      '#machine_name' => [
        'source' => [self::ELEMENT_KEY, 'label'],
      ],
      '#default_value' => 'example',
    ];

    return $element;
  }

}
