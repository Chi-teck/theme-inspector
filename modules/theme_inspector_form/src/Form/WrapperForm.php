<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Form;

use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * A simple form that renders a given element.
 */
final class WrapperForm implements FormInterface {

  public function getFormId(): string {
    return 'example';
  }

  public function buildForm(array $form, FormStateInterface $form_state): array {
    return \func_get_arg(2);
  }

  public function validateForm(array &$form, FormStateInterface $form_state): void {}

  public function submitForm(array &$form, FormStateInterface $form_state): void {}

}
