<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_entity\Form;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Entity type selection form.
 *
 * @property \Drupal\theme_inspector_entity\entity\EntityPreview $entity
 */
final class EntityTypeSelectionForm extends FormBase {

  /**
   * Having preview plugins for these entity types does not make much sense.
   */
  private const DISALLOWED_ENTITY_TYPES = [
    'contact_message',
    'content_moderation_state',
    'file',
    'menu_link_content',
    'path_alias',
    'shortcut',
    'tour',
    'workspace',
  ];

  public function __construct(private EntityTypeManagerInterface $entityTypeManager) {}

  public static function create(ContainerInterface $container) {
    return new self($container->get('entity_type.manager'));
  }

  public function getFormId(): string {
    return 'theme_inspector_entity_type_selection';
  }

  public function buildForm(array $form, FormStateInterface $form_state): array {

    $has_view_builder = static fn (EntityTypeInterface $definition): bool => $definition->hasViewBuilderClass();
    $is_allowed = static fn (EntityTypeInterface $definition): bool => !\in_array($definition->id(), self::DISALLOWED_ENTITY_TYPES);
    $has_uuid = static fn (EntityTypeInterface $definition): bool => $definition->hasKey('uuid');

    $definitions = $this->entityTypeManager->getDefinitions();

    $definitions = \array_filter($definitions, $has_view_builder);
    $definitions = \array_filter($definitions, $is_allowed);
    $definitions = \array_filter($definitions, $has_uuid);

    $get_label = static fn (EntityTypeInterface $definition): string => (string) $definition->getLabel();
    $options = ['' => $this->t('- Select -')] + \array_map($get_label, $definitions);

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
      ],
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
