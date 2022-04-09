<?php

namespace Drupal\Tests\theme_inspector_common\Kernel\Navigation;

use Drupal\KernelTests\KernelTestBase;
use Drupal\Tests\user\Traits\UserCreationTrait;
use Trafaret\PhpUnit\TrafaretTrait;
use Trafaret\Trafaret;

/**
 * @group theme_inspector_common
 */
final class AdminMenuTest extends KernelTestBase {

  use UserCreationTrait;

  use TrafaretTrait;

  protected static $modules = ['system', 'block', 'user', 'theme_inspector', 'theme_inspector_common'];

  public function setUp(): void {
    parent::setUp();
    $this->installConfig(['system']);
    $this->setUpCurrentUser(permissions: ['access administration pages']);
    $this->container->get('plugin.manager.menu.link')->rebuild();
  }

  public function testOutput() {

    // -- Collapsed.
    $trafaret = new Trafaret(
      <<< 'HTML'
        <ul>
          <li>
            <a href="/admin" data-drupal-link-system-path="admin">Administration</a>
          </li>
        </ul>
      HTML,
    );
    $build = $this->container
      ->get('plugin.manager.theme_preview')
      ->createInstance('admin_menu')
      ->build('collapsed');

    $html = $this->container->get('renderer')->renderRoot($build);
    $this->assertStringByTrafaret($trafaret, $html);

    // -- Expanded.
    $trafaret = new Trafaret(
      <<< 'HTML'
        <ul>
          <li>
            <a href="/admin" data-drupal-link-system-path="admin">Administration</a>
            <ul>
              <li>
                <a href="/admin/content" title="Find and manage content." data-drupal-link-system-path="admin/content">Content</a>
              </li>
              <li>
                <a href="/admin/structure" title="Administer blocks, content types, menus, etc." data-drupal-link-system-path="admin/structure">Structure</a>
              </li>
              <li>
                <a href="/admin/config" title="Administer settings." data-drupal-link-system-path="admin/config">Configuration</a>
                <ul>
                  <li>
                    <a href="/admin/config/people" title="Configure user accounts." data-drupal-link-system-path="admin/config/people">People</a>
                  </li>
                  <li>
                    <a href="/admin/config/system" title="Configure basic site settings, actions, and cron." data-drupal-link-system-path="admin/config/system">System</a>
                  </li>
                  <li>
                    <a href="/admin/config/content" title="Configure content formatting and authoring." data-drupal-link-system-path="admin/config/content">Content authoring</a>
                  </li>
                  <li>
                    <a href="/admin/config/user-interface" title="Configure the administrative user interface." data-drupal-link-system-path="admin/config/user-interface">User interface</a>
                  </li>
                  <li>
                    <a href="/admin/config/development" title="Configure and use development tools." data-drupal-link-system-path="admin/config/development">Development</a>
                  </li>
                  <li>
                    <a href="/admin/config/media" data-drupal-link-system-path="admin/config/media">Media</a>
                  </li>
                  <li>
                    <a href="/admin/config/search" title="Configure site search, metadata, and search engine optimization." data-drupal-link-system-path="admin/config/search">Search and metadata</a>
                  </li>
                  <li>
                    <a href="/admin/config/regional" title="Configure regional settings, localization, and translation." data-drupal-link-system-path="admin/config/regional">Regional and language</a>
                  </li>
                  <li>
                    <a href="/admin/config/services" data-drupal-link-system-path="admin/config/services">Web services</a>
                  </li>
                  <li>
                    <a href="/admin/config/workflow" title="Manage the content workflow." data-drupal-link-system-path="admin/config/workflow">Workflow</a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      HTML,
    );

    $build = $this->container
      ->get('plugin.manager.theme_preview')
      ->createInstance('admin_menu')
      ->build('expanded');

    $html = $this->container->get('renderer')->renderRoot($build);
    $this->assertStringByTrafaret($trafaret, $html);
  }

}
