<?php

namespace Drupal\Tests\theme_inspector_form\Kernel\Example;

use Drupal\KernelTests\KernelTestBase;
use Trafaret\PhpUnit\TrafaretTrait;
use Trafaret\Trafaret;

/**
 * @group theme_inspector_form
 */
final class PasswordFormTest extends KernelTestBase {

  use TrafaretTrait;

  protected static $modules = [
    'system',
    'theme_inspector',
    'theme_inspector_form',
    'user',
  ];

  public function testOutput(): void {
    $trafaret = new Trafaret(
      <<< 'HTML'
      <form class="user-pass" data-drupal-selector="user-pass" action="/" method="post" id="user-pass" accept-charset="UTF-8">
        <div class="js-form-item form-item js-form-type-textfield form-item-name js-form-item-name">
          <label for="edit-name" class="js-form-required form-required">Username or email address</label>
          <input autocorrect="off" autocapitalize="off" spellcheck="false" autofocus="autofocus" data-drupal-selector="edit-name" type="text" id="edit-name" name="name" value="" size="60" maxlength="254" class="form-text required" required="required" aria-required="true" />
        </div>
        <p>Password reset instructions will be sent to your registered email address.</p>
        <input autocomplete="off" data-drupal-selector="form-{{ token }}" type="hidden" name="form_build_id" value="form-{{ token }}" />
        <input data-drupal-selector="edit-user-pass" type="hidden" name="form_id" value="user_pass" />
        <div data-drupal-selector="edit-actions" class="form-actions js-form-wrapper form-wrapper" id="edit-actions">
          <input data-drupal-selector="edit-submit" type="submit" id="edit-submit" name="op" value="Submit" class="button js-form-submit form-submit" />
        </div>
      </form>
      HTML,
    );
    $build = $this->container
      ->get('plugin.manager.theme_preview')
      ->createInstance('password_form')
      ->build('default');

    $html = $this->container->get('renderer')->renderRoot($build);
    $this->assertStringByTrafaret($trafaret, $html);
  }

}
