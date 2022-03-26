<?php

namespace Drupal\Tests\theme_inspector\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * A test for settings form.
 *
 * @group theme_inspector
 */
final class SettingsFormTest extends BrowserTestBase {

  protected $defaultTheme = 'classy';

  protected static $modules = ['theme_inspector'];

  public function testSettingsForm() {
    $admin_user = $this->drupalCreateUser([
      'administer theme inspector configuration',
      'administer modules',
    ]);
    $this->drupalLogin($admin_user);

    $this->drupalGet('/admin/config/development/theme-inspector');
    $this->assertSession()->elementContains('css', 'h1', 'Theme Inspector Settings');
    $checkboxes = $this->getCheckboxes();

    self::assertSame('theme_inspector_common', $checkboxes[0]->getAttribute('value'));
    self::assertNull($checkboxes[0]->getAttribute('checked'));

    self::assertSame('theme_inspector_form', $checkboxes[1]->getAttribute('value'));
    self::assertNull($checkboxes[1]->getAttribute('checked'));

    // Check 'modules' link.
    $this->clickLink('here');
    $this->assertSession()->addressEquals('/admin/modules');

    // Install one provider and test if the corresponding checkbox is checked.
    $this->container->get('module_installer')->install(['theme_inspector_common'], TRUE);
    $this->drupalGet('/admin/config/development/theme-inspector');
    $checkboxes = $this->getCheckboxes();

    self::assertSame('theme_inspector_common', $checkboxes[0]->getAttribute('value'));
    self::assertSame('checked', $checkboxes[0]->getAttribute('checked'));

  }

  public function testAccess() {
    $admin_user = $this->drupalCreateUser(['administer theme inspector configuration']);
    $this->drupalLogin($admin_user);
    $this->drupalGet('/admin/config/development/theme-inspector');
    $this->assertSession()->statusCodeEquals(200);

    $admin_user = $this->drupalCreateUser(['access theme inspector']);
    $this->drupalLogin($admin_user);
    $this->drupalGet('/admin/config/development/theme-inspector');
    $this->assertSession()->statusCodeEquals(403);
  }

  private function getCheckboxes(): array {
    $fieldset = $this->xpath('//fieldset[//legend/span[text() = "Preview providers"]]')[0];
    $checkboxes = $fieldset->findAll('xpath', '//input[@type = "checkbox"]');
    self::assertCount(3, $checkboxes);
    return $checkboxes;
  }

}
