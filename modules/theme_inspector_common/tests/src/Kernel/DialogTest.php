<?php declare(strict_types = 1);

namespace Drupal\Tests\theme_inspector_common\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * @group theme_inspector_common
 */
final class DialogTest extends KernelTestBase {

  protected static $modules = ['system', 'theme_inspector', 'theme_inspector_common'];

  public function testDialogOutput() {
    $build = $this->container
      ->get('plugin.manager.theme_preview')
      ->createInstance('dialog')
      ->build('dialog');

    self::assertEquals(
      '<a href="/theme-inspector/example/form?destination=/%253Cnone%253E%3Fvariation%3Ddialog" class="use-ajax" data-dialog-type="dialog">Open the dialog</a>',
      $this->container->get('renderer')->renderRoot($build),
    );
  }

  public function testModalOutput() {
    $build = $this->container
      ->get('plugin.manager.theme_preview')
      ->createInstance('dialog')
      ->build('modal');

    self::assertEquals(
      '<a href="/theme-inspector/example/form?destination=/%253Cnone%253E%3Fvariation%3Dmodal" class="use-ajax" data-dialog-type="modal">Open the dialog</a>',
      $this->container->get('renderer')->renderRoot($build),
    );
  }

}
