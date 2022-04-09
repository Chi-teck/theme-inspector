<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview\Navigation;

use Drupal\Core\Block\BlockManagerInterface;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Render\Element;
use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * Admin Menu preview.
 *
 * @ThemePreview(
 *   id = "admin_menu",
 *   label = @Translation("Admin Menu"),
 *   category = @Translation("Navigation"),
 *   variations = {
 *     "expanded" = @Translation("Expanded"),
 *     "collapsed" = @Translation("Collapsed"),
 *   },
 * )
 */
final class AdminMenu extends ThemePreviewPluginBase {

  private const BLOCK_PLUGIN_ID = 'system_menu_block:admin';

  public function build(string $variation): array {

    if (!self::getModuleHandler()->moduleExists('block')) {
      return ['#markup' => $this->t('Block module is not installed')];
    }

    $configuration = [
      'label_display' => BlockPluginInterface::BLOCK_LABEL_VISIBLE,
      'level' => 1,
      'depth' => 0,
      'expand_all_items' => $variation === 'expanded',
    ];

    $manager = self::getBlockManager();
    if (!$manager->hasDefinition(self::BLOCK_PLUGIN_ID)) {
      return ['#markup' => $this->t('Plugin @plugin_id does not exist.', ['@plugin_id' => self::BLOCK_PLUGIN_ID])];
    }
    $build = $manager->createInstance(self::BLOCK_PLUGIN_ID, $configuration)->build();

    if (Element::isEmpty($build)) {
      return ['#markup' => $this->t('Menu is empty. Do you have permissions to see admin menu?')];
    }

    return $build;
  }

  private static function getModuleHandler(): ModuleHandlerInterface {
    return \Drupal::service('module_handler');
  }

  private static function getBlockManager(): BlockManagerInterface {
    return \Drupal::service('plugin.manager.block');
  }

}
