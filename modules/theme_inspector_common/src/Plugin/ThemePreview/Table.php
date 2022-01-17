<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview;

use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * A preview plugin for HTML tables.
 *
 * @ThemePreview(
 *   id = "table",
 *   label = @Translation("Table"),
 *   category = @Translation("Common"),
 *   variations = {
 *     "default" = @Translation("Default"),
 *     "sticky" = @Translation("Sticky"),
 *     "empty" = @Translation("Empty"),
 *   },
 * )
 */
final class Table extends ThemePreviewPluginBase {

  /**
   * {@inheritdoc}
   */
  public function build(string $variation): array {
    $header[] = [
      'data' => 'Column #1',
    ];
    $header[] = [
      'data' => 'Column #2',
    ];
    $header[] = [
      'data' => 'Column #3',
      'class' => [RESPONSIVE_PRIORITY_MEDIUM],
    ];
    $header[] = [
      'data' => 'Column #4',
      'class' => [RESPONSIVE_PRIORITY_MEDIUM],
    ];
    $header[] = [
      'data' => 'Column #5',
      'class' => [RESPONSIVE_PRIORITY_LOW],
    ];

    $rows = [];
    if ($variation !== 'empty') {
      for ($i = 1; $i <= 30; $i++) {
        $rows[] = [
          $this->random()->sentences(\mt_rand(1, 1)),
          $this->random()->sentences(\mt_rand(1, 3)),
          $this->random()->sentences(\mt_rand(1, 3)),
          $this->random()->sentences(\mt_rand(1, 3)),
          $this->random()->sentences(\mt_rand(1, 4)),
        ];
      }
    }

    $build = [
      '#type' => 'table',
      '#caption' => $this->t('Sample Table'),
      '#header' => $header,
      '#rows' => $rows,
      '#sticky' => $variation === 'sticky',
      '#empty' => 'No records were found.',
    ];
    return $build;
  }

}
