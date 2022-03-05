<?php declare(strict_types = 1);

namespace Drupal\theme_inspector\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a sample form for testing preview plugins.
 */
final class ExampleForm extends FormBase {

  public function getFormId(): string {
    return 'theme_inspector_example';
  }

  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
    ];

    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state): void {
    // Deliberately empty.
  }

}
