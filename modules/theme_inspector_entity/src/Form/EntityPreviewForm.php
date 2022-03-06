<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_entity\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Entity Preview form.
 *
 * @property \Drupal\theme_inspector_entity\Entity\EntityPreview $entity
 */
class EntityPreviewForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    if ($this->entity->isNew()) {
      $entity_type_id = $this->getRouteMatch()->getParameter('entity_type');
      if (!$this->entityTypeManager->getDefinition($entity_type_id, FALSE)?->hasViewBuilderClass()) {
        throw new NotFoundHttpException();
      }
    }
    else {
      $entity_type_id = $this->entity->getReferencedEntityTypeId();
    }

    if (!$entity_type_id) {
      throw new NotFoundHttpException();
    }

    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#description' => $this->t('Label for the entity preview.'),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => '\Drupal\theme_inspector_entity\Entity\EntityPreview::load',
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    $form['entity_type_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Entity Type'),
      '#default_value' => $entity_type_id,
      '#disabled' => TRUE,
    ];

    $form['entity_id'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Entity'),
      '#target_type' => $entity_type_id,
      '#required' => TRUE,
    ];

    if ($entity_uuid = $this->entity->get('entity_uuid')) {
      $entities = $this->entityTypeManager->getStorage($entity_type_id)->loadByProperties(['uuid' => $entity_uuid]);
      if (\count($entities) > 0) {
        $form['entity_id']['#default_value'] = \reset($entities);
      }
    }

    return $form;
  }

  public function save(array $form, FormStateInterface $form_state) {

    $entity_id = $form_state->getValue('entity_id');
    $entity_type_id = $form_state->getValue('entity_type_id');
    $entity = $this->entityTypeManager->getStorage($entity_type_id)->load($entity_id);

    $this->entity->set('entity_uuid', $entity->uuid());

    $result = parent::save($form, $form_state);

    $message_args = ['%label' => $this->entity->label()];
    $message = match($result) {
      \SAVED_NEW => $this->t('Created new entity preview %label.', $message_args),
      \SAVED_UPDATED => $this->t('Updated entity preview %label.', $message_args),
    };
    $this->messenger()->addStatus($message);
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));

    return $result;
  }

}
