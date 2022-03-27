<?php declare(strict_types = 1);

namespace Drupal\theme_inspector;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\Extension;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\theme_inspector\Annotation\ThemePreview;
use Drupal\theme_inspector\Routing\UrlGenerator;

/**
 * A plugin manager for Theme Preview plugins.
 *
 * @method createInstance($plugin_id, array $configuration = []): ThemePreviewInterface
 */
final class ThemePreviewPluginManager extends DefaultPluginManager implements ThemePreviewRegistryInterface {

  use StringTranslationTrait;

  private array $registry = [];

  public function __construct(
    \Traversable $namespaces,
    CacheBackendInterface $cache_backend,
    ModuleHandlerInterface $module_handler,
    private UrlGenerator $urlGenerator,
    private ThemeDefinitionDiscovery $themeDefinitionDiscovery,
  ) {
    parent::__construct(
      'Plugin/ThemePreview',
      $namespaces,
      $module_handler,
      ThemePreviewInterface::class,
      ThemePreview::class,
    );
    $this->alterInfo('theme_preview_info');
    $this->setCacheBackend($cache_backend, 'theme_preview_plugins');
  }

  public function getDefinitions(): array {
    $theme_definitions = $this->themeDefinitionDiscovery->getDefinitions();
    \array_walk($theme_definitions, [self::class, 'processDefinition']);
    $this->definitions = parent::getDefinitions() + $theme_definitions;
    return $this->definitions;
  }

  public function processDefinition(&$definition, $plugin_id): void {
    parent::processDefinition($definition, $plugin_id);
    $definition['id'] ??= $plugin_id;
    $definition['variations'] ??= ['default' => $this->t('Default')];
    $definition['default_variation'] = \array_key_first($definition['variations']);
    $definition['category'] ??= $this->t('Miscellaneous');
    $definition['theme'] ??= NULL;
    if (!\array_key_exists('class', $definition)) {
      if (!\array_key_exists('callback', $definition)) {
        throw new \LogicException(\sprintf('Plugin %s specifies neither class nor callback.', $plugin_id));
      }
      $definition['class'] = ThemePreviewPluginCallback::class;
    }
  }

  public function buildGroupedRegistry(Extension $theme): array {
    $registry = [];
    foreach ($this->buildRegistry($theme) as $preview) {
      $registry[$preview['category']][] = $preview;
    }
    $compare_labels = static fn (array $a, array $b): int => \strcmp($a['label'], $b['label']);
    $sort_branch = static fn (array &$branch): bool => \usort($branch, $compare_labels);
    \array_walk($registry, $sort_branch);
    \ksort($registry);
    return $registry;
  }

  public function buildRegistry(Extension $theme): array {

    $theme_name = $theme->getName();
    if (isset($this->registry[$theme_name])) {
      return $this->registry[$theme_name];
    }

    $registry = [];
    foreach ($this->getDefinitions() as $definition_id => $definition) {
      if ($definition['theme'] && $definition['theme'] !== $theme_name) {
        continue;
      }
      $variations = [];
      foreach ($definition['variations'] as $id => $label) {
        $variations[$id] = [
          'label' => (string) $label,
          'url' => $this->urlGenerator->generatePreviewUrl($theme_name, $definition_id, $id),
        ];
      }
      $registry[$definition_id] = [
        'id' => $definition_id,
        'label' => (string) $definition['label'],
        'category' => (string) $definition['category'],
        'url' => $this->urlGenerator->generateOverviewUrl(
          $theme_name,
          $definition_id,
          $definition['default_variation'],
        ),
        'variations' => $variations,
      ];
    }

    $this->registry[$theme_name] = $registry;
    return $registry;
  }

}
