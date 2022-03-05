<?php

namespace Drupal\Tests\theme_inspector_common\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Symfony\Component\Validator\Constraints\Length;
use Trafaret\PhpUnit\TrafaretTrait;
use Trafaret\Trafaret;

/**
 * @group theme_inspector_common
 */
final class DetailsTest extends KernelTestBase {

  use TrafaretTrait;

  protected static $modules = ['system', 'theme_inspector', 'theme_inspector_common'];

  public function testOutput() {
    $trafaret = new Trafaret(
      <<< 'HTML'
        <details class="js-form-wrapper form-wrapper" open="open">
          <summary role="button" aria-expanded="true" aria-pressed="true">Example</summary>
          {{ content }}
        </details>
      HTML,
      ['content' => new Length(min: 50)],
    );
    $build = $this->container
      ->get('plugin.manager.theme_preview')
      ->createInstance('details')
      ->build('default');

    $html = $this->container->get('renderer')->renderRoot($build);
    $this->assertStringByTrafaret($trafaret, $html);
  }

}
