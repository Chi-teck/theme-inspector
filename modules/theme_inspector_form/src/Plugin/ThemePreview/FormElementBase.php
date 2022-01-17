<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_form\Plugin\ThemePreview;

use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\theme_inspector\ThemePreviewPluginBase;
use Drupal\theme_inspector_form\Form\WrapperForm;
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

  public function build(string $variation): array {
    return $this->formBuilder->getForm(new WrapperForm(), $this->getElement($variation));
  }

  abstract protected function getElement(string $variation): array;

}
