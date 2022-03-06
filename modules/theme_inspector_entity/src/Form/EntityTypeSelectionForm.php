<?php declare(strict_types = 1);
namespace Drupal\theme_inspector_entity\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Entity type selection form.
 *
 * @property \Drupal\theme_inspector_entity\EntityPreviewInterface $entity
 */
class EntityTypeSelectionForm extends FormBase {

  public function getFormId(): string {
    return 'theme_inspector_entity_type_selection';
  }

  public function buildForm(array $form, FormStateInterface $form_state): array {
    $this->entityTypeManager = \Drupal::entityTypeManager();
    $definitions = $this->entityTypeManager->getDefinitions();
    $options = ['' => $this->t('- Select -')];
    foreach ($definitions as $definition) {
      if ($definition->hasViewBuilderClass()) {
        $options[$definition->id()] = $definition->getLabel();
      }
    }

    $form['entity_type'] = [
      '#title' => $this->t('Entity Type'),
      '#type' => 'select',
      '#options' => $options,
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

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $entity_type = $form_state->getValue('entity_type');
    $form_state->setRedirect('entity.theme_inspector_entity_preview.add_form', ['entity_type' => $entity_type]);
  }

}
