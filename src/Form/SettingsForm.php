<?php declare(strict_types = 1);

namespace Drupal\theme_inspector\Form;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a settings form for Theme Inspector.
 */
final class SettingsForm extends FormBase {

  private const PROVIDERS = [
    'theme_inspector_common',
    'theme_inspector_form',
  ];

  public function __construct(private ModuleHandlerInterface $moduleHandler) {}

  public static function create(ContainerInterface $container): self {
    return new self($container->get('module_handler'));
  }

  public function getFormId(): string {
    return 'theme_inspector_settings';
  }

  public function buildForm(array $form, FormStateInterface $form_state): array {

    $default_value = [];
    $options = [];
    foreach (self::PROVIDERS as $provider) {
      $options[$provider] = $this->moduleHandler->getName($provider);
      if ($this->moduleHandler->moduleExists($provider)) {
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

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state): array {
    // Intentionally empty.
  }

}
