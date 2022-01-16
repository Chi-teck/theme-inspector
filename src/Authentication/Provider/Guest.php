<?php declare(strict_types = 1);

namespace Drupal\theme_inspector\Authentication\Provider;

use Drupal\Core\Authentication\AuthenticationProviderInterface;
use Drupal\Core\Session\UserSession;
use Symfony\Component\HttpFoundation\Request;

/**
 * Authenticates the user as anonymous when accessing the preview route.
 */
final class Guest implements AuthenticationProviderInterface {

  private const PREVIEW_PATH_PREFIX = '/theme-inspector/preview/';

  public function applies(Request $request): bool {
    return \str_starts_with($request->getPathInfo(), self::PREVIEW_PATH_PREFIX) && !$request->query->getBoolean('auth');
  }

  public function authenticate(Request $request): UserSession {
    return new UserSession();
  }

}
