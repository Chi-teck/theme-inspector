<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\theme_inspector\ThemePreviewPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base class for form element previews.
 */
abstract class FormElementBase extends ThemePreviewPluginBase implements ContainerFactoryPluginInterface {

  public function __construct(array $configuration, $plugin_id, $plugin_definition, private FormBuilderInterface $formBuilder) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('form_builder'));
  }

  public function build(string $variation_id): array {
    return $this->getForm($variation_id, $this->getElement($variation_id));
  }

  abstract protected function getElement(string $variation_id): array;

  private function getForm(string $variation_id, array $element) {

    $form = new class implements FormInterface {

      public function getFormId(): string {
        return 'example';
      }

      public function buildForm(array $form, FormStateInterface $form_state): array {
        $variation_id = \func_get_arg(2);
        $element = \func_get_arg(3);
        $common = [
          '#title' => 'Example',
          '#required' => TRUE,
          '#disabled' => $variation_id === 'disabled',
          '#placeholder' => 'Placeholder',
        ];
        return ['example' => $element + $common];
      }

      public function validateForm(array &$form, FormStateInterface $form_state): void {}

      public function submitForm(array &$form, FormStateInterface $form_state): void {}

    };

    return $this->formBuilder->getForm($form, $variation_id, $element);
  }

}
