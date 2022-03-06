<?php declare(strict_types = 1);

namespace Drupal\Tests\theme_inspector_common\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * @group theme_inspector_common
 */
final class OffCanvasTest extends KernelTestBase {

  protected static $modules = ['system', 'theme_inspector', 'theme_inspector_common'];

  public function testDefaultOutput() {
    $build = $this->container
      ->get('plugin.manager.theme_preview')
      ->createInstance('off_canvas')
      ->build('default');

    self::assertEquals(
      '<a href="/theme-inspector/example/form?destination=/%253Cnone%253E%3Fvariation%3Ddefault" class="use-ajax" data-dialog-type="dialog" data-dialog-renderer="off_canvas">Open the off-canvas dialog</a>',
      $this->container->get('renderer')->renderRoot($build),
    );
  }

  public function testTopOutput() {
    $build = $this->container
      ->get('plugin.manager.theme_preview')
      ->createInstance('off_canvas')
      ->build('top');

    self::assertEquals(
      '<a href="/theme-inspector/example/form?destination=/%253Cnone%253E%3Fvariation%3Dtop" class="use-ajax" data-dialog-type="dialog" data-dialog-renderer="off_canvas_top">Open the off-canvas dialog</a>',
      $this->container->get('renderer')->renderRoot($build),
    );
  }

}
