<?php declare(strict_types = 1);

namespace Drupal\theme_inspector;

/**
 * Interface for theme preview plugins.
 */
interface ThemePreviewInterface {

  public function id(): string;

  public function getLabel(): string;

  public function getCategory(): string;

  public function getVariations(): array;

  public function build(string $variation): array;

}
