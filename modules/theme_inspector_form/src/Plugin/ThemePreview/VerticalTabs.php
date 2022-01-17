<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

/**
 * Vertical Tabs preview.
 *
 * @ThemePreview(
 *   id = "vertical_tabs",
 *   label = @Translation("Vertical Tabs"),
 *   category = @Translation("Form Elements"),
 * )
 */
final class VerticalTabs extends FormElementBase {

  public function getElement(string $variation): array {

    $element['information'] = [
      '#type' => 'vertical_tabs',
      '#default_tab' => 'edit-publication',
    ];

    for ($i = 1; $i <= 5; $i++) {
      $element['tab_' . $i] = [
        '#type' => 'details',
        '#title' => $this->random()->sentences(2, TRUE),
        '#group' => 'information',
        'content' => [
          '#markup' => \nl2br($this->random()->paragraphs(3)),
        ],
      ];
    }

    return $element;
  }

}
