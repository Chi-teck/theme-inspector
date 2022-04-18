<?php

namespace Drupal\theme_inspector\Form;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Configure Theme Inspector settings for this site.
 */
final class SettingsForm extends ConfigFormBase {

  private const PROVIDERS = [
    'theme_inspector_common',
    'theme_inspector_form',
    'theme_inspector_entity',
  ];

  public function getFormId(): string {
    return 'theme_inspector_settings';
  }

  protected function getEditableConfigNames(): array {
    return ['theme_inspector.settings'];
  }

  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['load_previous'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Load previous preview when switching theme'),
      '#description' => $this->t('This might be useful for testing a component in different themes.'),
      '#default_value' => $this->config('theme_inspector.settings')->get('load_previous'),
    ];

    $default_value = [];
    $options = [];
    $module_handler = self::getModuleHandler();
    foreach (self::PROVIDERS as $provider) {
      $options[$provider] = $module_handler->getName($provider);
      if ($module_handler->moduleExists($provider)) {
        $default_value[] = $provider;
      }
    }

    $form['preview_providers'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Preview providers'),
      '#options' => $options,
      '#disabled' => TRUE,
      '#default_value' => $default_value,
    ];

    if ($this->currentUser()->hasPermission('administer modules')) {
      $form['preview_providers']['#description'] = $this->t(
        'Preview providers can be installed <a href=":modules_url">here</a>.',
        [':modules_url' => Url::fromRoute('system.modules_list')->toString()],
      );
    }

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('theme_inspector.settings')
      ->set('load_previous', $form_state->getValue('load_previous'))
      ->save();
    parent::submitForm($form, $form_state);
  }

  private static function getModuleHandler(): ModuleHandlerInterface {
    return \Drupal::moduleHandler();
  }

}
