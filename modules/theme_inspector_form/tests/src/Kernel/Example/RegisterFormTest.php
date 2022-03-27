<?php

namespace Drupal\Tests\theme_inspector_form\Kernel\Example;

use Drupal\KernelTests\KernelTestBase;
use Trafaret\PhpUnit\TrafaretTrait;
use Trafaret\Trafaret;

/**
 * @group theme_inspector_form
 */
final class RegisterFormTest extends KernelTestBase {

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
      <form class="user-form" data-drupal-selector="user-form" action="/" method="post" id="user-form" accept-charset="UTF-8">
        <div data-drupal-selector="edit-account" id="edit-account" class="js-form-wrapper form-wrapper">
          <div class="js-form-item form-item js-form-type-email form-item-mail js-form-item-mail">
            <label for="edit-mail" class="js-form-required form-required">Email address</label>
            <input data-drupal-selector="edit-mail" aria-describedby="edit-mail--description" type="email" id="edit-mail" name="mail" value="" size="60" maxlength="254" class="form-email required" required="required" aria-required="true" />
            <div id="edit-mail--description" class="description">
              A valid email address. All emails from the system will be sent to this address. The email address is not made public and will only be used if you wish to receive a new password or wish to receive certain news or notifications by email.
            </div>
          </div>
          <div class="js-form-item form-item js-form-type-textfield form-item-name js-form-item-name">
            <label for="edit-name" class="js-form-required form-required">Username</label>
            <input class="username form-text required" autocorrect="off" autocapitalize="off" spellcheck="false" data-drupal-selector="edit-name" aria-describedby="edit-name--description" type="text" id="edit-name" name="name" value="" size="60" maxlength="60" required="required" aria-required="true" />
            <div id="edit-name--description" class="description">
              Several special characters are allowed, including space, period (.), hyphen (-), apostrophe ('), underscore (_), and the @ sign.
            </div>
          </div>
          <div id="edit-pass" class="js-form-item form-item js-form-type-password-confirm form-item-pass js-form-item-pass form-no-label">
            <div class="js-form-item form-item js-form-type-password form-item-pass-pass1 js-form-item-pass-pass1">
              <label for="edit-pass-pass1" class="js-form-required form-required">Password</label>
              <input class="password-field js-password-field form-text required" autocomplete="new-password" data-drupal-selector="edit-pass-pass1" type="password" id="edit-pass-pass1" name="pass[pass1]" size="25" maxlength="128" required="required" aria-required="true" />
            </div>
            <div class="js-form-item form-item js-form-type-password form-item-pass-pass2 js-form-item-pass-pass2">
              <label for="edit-pass-pass2" class="js-form-required form-required">Confirm password</label>
              <input class="password-confirm js-password-confirm form-text required" autocomplete="new-password" data-drupal-selector="edit-pass-pass2" type="password" id="edit-pass-pass2" name="pass[pass2]" size="25" maxlength="128" required="required" aria-required="true" />
            </div>
            <div id="edit-pass--description" class="description">
              Provide a password for the new account in both fields.
            </div>
          </div>
        </div>
        <input autocomplete="off" data-drupal-selector="form-{{ token }}" type="hidden" name="form_build_id" value="form-{{ token }}" />
        <input data-drupal-selector="edit-user-form" type="hidden" name="form_id" value="user_form" />
        <div data-drupal-selector="edit-actions" class="form-actions js-form-wrapper form-wrapper" id="edit-actions">
          <input data-drupal-selector="edit-submit" type="submit" id="edit-submit" name="op" value="Save" class="button button--primary js-form-submit form-submit" />
        </div>
      </form>
      HTML,
    );
    $build = $this->container
      ->get('plugin.manager.theme_preview')
      ->createInstance('register_form')
      ->build('default');

    $html = $this->container->get('renderer')->renderRoot($build);
    $this->assertStringByTrafaret($trafaret, $html);
  }

}
