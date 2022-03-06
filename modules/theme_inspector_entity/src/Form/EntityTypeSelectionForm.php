<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_entity\Form;

use Drupal\Core\Config\Entity\ConfigEntityTypeInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Entity type selection form.
 *
 * @property \Drupal\theme_inspector_entity\entity\EntityPreview $entity
 */
final class EntityTypeSelectionForm extends FormBase {

  public function getFormId(): string {
    return 'theme_inspector_entity_type_selection';
  }

  public function buildForm(array $form, FormStateInterface $form_state): array {
    $this->entityTypeManager = \Drupal::entityTypeManager();

    $has_view_builder = static fn (EntityTypeInterface $definition): bool => $definition->hasViewBuilderClass();
    $get_label = static fn (EntityTypeInterface $definition): string => (string) $definition->getLabel();

    $options = ['' => $this->t('- Select -')];
    $options += \array_map(
      $get_label, \array_filter($this->entityTypeManager->getDefinitions(), $has_view_builder),
    );

    $form['entity_type_id'] = [
      '#title' => $this->t('Entity Type'),
      '#type' => 'select',
      '#options' => $options,
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
      ]
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $form_state->setRedirect(
      'entity.theme_inspector_entity_preview.add_form',
      ['entity_type' => $form_state->getValue('entity_type_id')],
    );
  }

}
