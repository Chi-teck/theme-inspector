<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview\Navigation;

use Drupal\Core\Url;
use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * A preview plugin for local tasks (tabs).
 *
 * @ThemePreview(
 *   id = "local_tasks",
 *   label = @Translation("Tabs"),
 *   category = @Translation("Navigation"),
 * )
 *
 * Known issues:
 *   • Bartik's CSS expects the tabs to be rendered inside ".tabs" container
 *     that is set in block--local-tasks-block.html.twig template.
 *   • Seven's CSS expects the tabs to be rendered inside a container with
 *     "overflow: hidden".
 */
final class LocalTasks extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    return [
      '#theme' => 'menu_local_tasks',
      '#primary' => [
        'example_11' => self::buildLocalTask('Example 1', TRUE),
        'example_12' => self::buildLocalTask('Example 2', FALSE),
        'example_13' => self::buildLocalTask('Example 3', FALSE),
      ],
      '#secondary' => [
        'example_21' => self::buildLocalTask('Example 1', TRUE),
        'example_22' => self::buildLocalTask('Example 2', FALSE),
        'example_23' => self::buildLocalTask('Example 3', FALSE),
      ],
    ];
  }

  private static function buildLocalTask(string $title, bool $active): array {
    $params = $active ? [] : ['example' => $title];
    $options = $active ? ['attributes' => ['class' => ['is-active']]] : [];
    return [
      '#theme' => 'menu_local_task',
      '#link' => [
        'title' => $title,
        'url' => Url::fromRoute('<current>', $params, $options),
      ],
      '#active' => $active,
    ];
  }

}
