<?php declare(strict_types = 1);

namespace Drupal\Tests\theme_inspector\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\theme_inspector\ThemePreviewInterface;

/**
 * Tests for theme preview plugin manager.
 *
 * @group theme_inspector
 */
final class ThemePreviewPluginManagerTest extends KernelTestBase {

  protected static $modules = ['theme_inspector', 'theme_inspector_common'];

  public function testCreateInstance(): void {
    $plugin_manager = $this->container->get('plugin.manager.theme_preview');
    $plugin = $plugin_manager->createInstance('details');
    self::assertInstanceOf(ThemePreviewInterface::class, $plugin);
    self::assertSame('details', $plugin->getPluginDefinition()['id']);
  }

  public function testProcessDefinition(): void {
    $plugin_manager = $this->container->get('plugin.manager.theme_preview');

    $definition = [
      'category' => 'Common',
      'variations' => ['foo' => 'Foo'],
    ];
    $plugin_manager->processDefinition($definition, 'example');
    self::assertEquals($definition['category'], 'Common');
    self::assertEquals($definition['variations'], ['foo' => 'Foo']);

    $definition = [];
    $plugin_manager->processDefinition($definition, 'example');
    self::assertEquals($definition['category'], 'Miscellaneous');
    self::assertEquals($definition['variations'], ['default' => 'Default']);
  }

  public function testBuildRegistry(): void {
    $plugin_manager = $this->container->get('plugin.manager.theme_preview');
    $this->container->get('theme_installer')->install(['bartik']);
    $theme = $this->container->get('theme_handler')->getTheme('bartik');

    $registry = $plugin_manager->buildRegistry($theme);
    self::assertGreaterThan(10, \count($registry));

    $expected = [
      'id' => 'details',
      'label' => 'Details',
      'category' => 'Common',
      'url' => '/admin/appearance/theme-inspector/bartik?preview=details&variation=default',
      'variations' =>
        [
          'default' =>
            [
              'label' => 'Default',
              'url' => '/theme-inspector/preview/bartik/details?variation=default&token=TOKEN',
            ],
        ],
    ];
    self::assertRegistryItem($expected, $registry['details']);
  }

  public function testBuildGroupedRegistry(): void {
    $plugin_manager = $this->container->get('plugin.manager.theme_preview');
    $this->container->get('theme_installer')->install(['bartik']);
    $theme = $this->container->get('theme_handler')->getTheme('bartik');

    $registry = $plugin_manager->buildGroupedRegistry($theme);

    $categories = [
      'Common',
      'Navigation',
      'Typography',
    ];
    self::assertSame($categories, \array_keys($registry));

    self::assertCount(5, $registry['Common']);
    self::assertCount(5, $registry['Navigation']);
    self::assertCount(5, $registry['Typography']);

    $expected = [
      'id' => 'details',
      'label' => 'Details',
      'category' => 'Common',
      'url' => '/admin/appearance/theme-inspector/bartik?preview=details&variation=default',
      'variations' =>
        [
          'default' =>
            [
              'label' => 'Default',
              'url' => '/theme-inspector/preview/bartik/details?variation=default&token=TOKEN',
            ],
        ],
    ];
    self::assertRegistryItem($expected, $registry['Common'][0]);
  }

  private static function assertRegistryItem(array $expected, array $actual): void {
    // Clean token.
    $actual['variations']['default']['url'] = \preg_replace(
      '#token=.+$#',
      'token=TOKEN',
      $actual['variations']['default']['url'],
    );
    self::assertSame($expected, $actual);
  }

}
