<?php declare(strict_types = 1);

namespace Drupal\theme_inspector\Theme;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;

/**
 * A theme negotiator that sets active theme based on the route parameter.
 */
final class PreviewThemeNegotiator implements ThemeNegotiatorInterface {

  public function applies(RouteMatchInterface $route_match): bool {
    return $route_match->getRouteName() === 'theme_inspector.preview';
  }

  public function determineActiveTheme(RouteMatchInterface $route_match): string {
    return $route_match->getParameter('theme')->getName();
  }

}
