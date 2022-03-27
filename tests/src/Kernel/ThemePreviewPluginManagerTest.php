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

    // -- Fully defined definition.
    $definition = [
      'category' => 'Common',
      'variations' => ['foo' => 'Foo', 'bar' => 'Bar'],
      'default_variation' => 'bar',
      'theme' => 'claro',
      'class' => 'Example',
    ];
    $plugin_manager->processDefinition($definition, 'example');
    self::assertSame($definition['category'], 'Common');
    self::assertSame($definition['variations'], ['foo' => 'Foo', 'bar' => 'Bar']);
    self::assertSame($definition['default_variation'], 'foo');
    self::assertSame($definition['theme'], 'claro');

    // -- Minimally defined definition.
    $definition = ['class' => 'Example'];
    $plugin_manager->processDefinition($definition, 'example');
    self::assertEquals($definition['category'], 'Miscellaneous');
    self::assertEquals($definition['variations'], ['default' => 'Default']);
    self::assertEquals($definition['default_variation'], 'default');
    self::assertNull($definition['theme']);

    // -- Wrong definition.
    $definition = [];
    self::expectException(\LogicException::class);
    self::expectExceptionMessage('Plugin example specifies neither class nor callback.');
    $plugin_manager->processDefinition($definition, 'example');
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
      'Miscellaneous',
      'Navigation',
      'Typography',
    ];
    self::assertSame($categories, \array_keys($registry));

    self::assertCount(7, $registry['Common']);
    self::assertCount(6, $registry['Navigation']);
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
