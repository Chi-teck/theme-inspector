<?php declare(strict_types = 1);

namespace Drupal\Tests\theme_inspector_common\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\user\Entity\User;
use Trafaret\PhpUnit\TrafaretTrait;

/**
 * @group theme_inspector_common
 */
final class UsernameTest extends KernelTestBase {

  use TrafaretTrait;

  protected static $modules = ['theme_inspector', 'theme_inspector_common', 'user'];

  public function setUp(): void {
    parent::setUp();
    $this->installEntitySchema('user');
    $user = User::create(['name' => 'Example']);
    $user->save();
    $this->container->get('current_user')->setAccount($user);
  }

  public function testOutput() {
    $build = $this->container
      ->get('plugin.manager.theme_preview')
      ->createInstance('username')
      ->build('default');

    $this->assertEquals(
      '<a title="View user profile." href="/user/1">Example</a>',
      $this->container->get('renderer')->renderRoot($build),
    );
  }

}
