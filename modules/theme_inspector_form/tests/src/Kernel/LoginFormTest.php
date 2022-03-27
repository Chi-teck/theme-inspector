<?php

namespace Drupal\Tests\theme_inspector_form\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Trafaret\PhpUnit\TrafaretTrait;
use Trafaret\Trafaret;

/**
 * @group theme_inspector_form
 */
final class LoginFormTest extends KernelTestBase {

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
      <form class="user-login-form" data-drupal-selector="user-login-form" action="/" method="post" id="user-login-form" accept-charset="UTF-8">
        <div class="js-form-item form-item js-form-type-textfield form-item-name js-form-item-name">
          <label for="edit-name" class="js-form-required form-required">Username</label>
            <input autocorrect="none" autocapitalize="none" spellcheck="false" autofocus="autofocus" data-drupal-selector="edit-name" aria-describedby="edit-name--description" type="text" id="edit-name" name="name" value="" size="60" maxlength="60" class="form-text required" required="required" aria-required="true" />
            <div id="edit-name--description" class="description">
              Enter your  username.
            </div>
        </div>
        <div class="js-form-item form-item js-form-type-password form-item-pass js-form-item-pass">
          <label for="edit-pass" class="js-form-required form-required">Password</label>
          <input data-drupal-selector="edit-pass" aria-describedby="edit-pass--description" type="password" id="edit-pass" name="pass" size="60" maxlength="128" class="form-text required" required="required" aria-required="true" />
          <div id="edit-pass--description" class="description">
            Enter the password that accompanies your username.
          </div>
        </div>
        <input autocomplete="off" data-drupal-selector="form-{{ token }}" type="hidden" name="form_build_id" value="form-{{ token }}" />
        <input data-drupal-selector="edit-user-login-form" type="hidden" name="form_id" value="user_login_form" />
        <div data-drupal-selector="edit-actions" class="form-actions js-form-wrapper form-wrapper" id="edit-actions">
          <input data-drupal-selector="edit-submit" type="submit" id="edit-submit" name="op" value="Log in" class="button js-form-submit form-submit" />
        </div>
      </form>
      HTML,
    );
    $build = $this->container
      ->get('plugin.manager.theme_preview')
      ->createInstance('login_form')
      ->build('default');

    $html = $this->container->get('renderer')->renderRoot($build);
    $this->assertStringByTrafaret($trafaret, $html);
  }

}
