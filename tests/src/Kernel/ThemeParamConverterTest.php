<?php declare(strict_types = 1);

namespace Drupal\Tests\theme_inspector\Kernel;

use Drupal\Core\Extension\Extension;
use Drupal\KernelTests\KernelTestBase;
use Symfony\Component\Routing\Route;

/**
 * Tests the theme parameter converter.
 *
 * @group theme_inspector
 */
final class ThemeParamConverterTest extends KernelTestBase {

  protected static $modules = ['theme_inspector', 'system'];

  /**
   * Test callback.
   */
  public function testApplies(): void {
    $converter = $this->container->get('theme_inspector.theme_param_converter');

    $name = 'theme';
    $route = new Route('/example');

    $definition = [];
    self::assertFalse($converter->applies($definition, $name, $route));

    $definition = ['type' => NULL];
    self::assertFalse($converter->applies($definition, $name, $route));

    $definition = ['type' => 'foo'];
    self::assertFalse($converter->applies($definition, $name, $route));

    $definition = ['type' => 'ti_theme'];
    self::assertTrue($converter->applies($definition, $name, $route));
  }

  public function testConvert(): void {

    $this->container->get('theme_installer')->install(['classy']);
    $this->installConfig(['system']);
    $this->config('system.theme')->set('default', 'classy')->save();

    $converter = $this->container->get('theme_inspector.theme_param_converter');

    $theme = $converter->convert('classy', [], 'ti_theme', []);
    self::assertInstanceOf(Extension::class, $theme);
    self::assertEquals('classy', $theme->getName());

    $theme = $converter->convert(NULL, [], 'ti_theme', []);
    self::assertInstanceOf(Extension::class, $theme);
    self::assertEquals('classy', $theme->getName());

    // Claro is not installed.
    self::assertNull($converter->convert('claro', [], 'ti_theme', []));
    self::assertNull($converter->convert('non_existing_theme', [], 'ti_theme', []));
  }

}
