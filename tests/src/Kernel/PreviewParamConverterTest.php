<?php declare(strict_types = 1);

namespace Drupal\Tests\theme_inspector\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\theme_inspector_form\Plugin\ThemePreview\Select;
use Symfony\Component\Routing\Route;

/**
 * Tests the theme parameter converter.
 *
 * @group theme_inspector
 */
final class PreviewParamConverterTest extends KernelTestBase {

  protected static $modules = [
    'theme_inspector',
    'theme_inspector_form',
  ];

  public function testApplies(): void {
    $converter = $this->container->get('theme_inspector.preview_param_converter');

    $name = 'preview';
    $route = new Route('/example');

    $definition = [];
    self::assertFalse($converter->applies($definition, $name, $route));

    $definition = ['type' => NULL];
    self::assertFalse($converter->applies($definition, $name, $route));

    $definition = ['type' => 'foo'];
    self::assertFalse($converter->applies($definition, $name, $route));

    $definition = ['type' => 'ti_preview'];
    self::assertTrue($converter->applies($definition, $name, $route));
  }

  public function testConvert(): void {
    $converter = $this->container->get('theme_inspector.preview_param_converter');

    $preview = $converter->convert('select', [], 'ti_preview', []);
    self::assertInstanceOf(Select::class, $preview);
    self::assertEquals('Select', $preview->getPluginDefinition()['label']);

    self::assertNull($converter->convert(NULL, [], 'ti_preview', []));
    self::assertNull($converter->convert('non_existing_preview', [], 'ti_preview', []));
  }

}
