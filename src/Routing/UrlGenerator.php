<?php declare(strict_types = 1);

namespace Drupal\theme_inspector\Routing;

use Drupal\Core\Routing\UrlGeneratorInterface;
use Drupal\Core\Url;

/**
 * URL generator for the module routes.
 */
final class UrlGenerator {

  public function __construct(private UrlGeneratorInterface $urlGenerator) {}

  public function generateOverviewUrl(string $theme, string $preview, string $variation): string {
    return Url::fromRoute(
      'theme_inspector.overview_theme',
      ['theme' => $theme],
      [
        'query' => [
          'preview' => $preview,
          'variation' => $variation,
        ],
      ],
    )->toString();
  }

  public function generatePreviewUrl(string $theme, string $preview, string $variation): string {
    // Preview URL must be generated using non-bubbling URL generator.
    // @see https://www.drupal.org/project/drupal/issues/2857412
    return $this->urlGenerator->generateFromRoute(
      'theme_inspector.preview',
      ['theme' => $theme, 'preview' => $preview],
      ['query' => ['variation' => $variation]],
    );
  }

}
