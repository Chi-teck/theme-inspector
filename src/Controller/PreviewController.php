<?php declare(strict_types = 1);

namespace Drupal\theme_inspector\Controller;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Component\Render\FormattableMarkup as FM;
use Drupal\Core\Extension\Extension;
use Drupal\theme_inspector\ThemePreviewInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Returns responses for Theme Inspector routes.
 */
final class PreviewController {

  public function __invoke(Request $request, Extension $theme, ThemePreviewInterface&PluginInspectionInterface $preview): array {
    [
      'theme' => $theme_name,
      'variations' => $variations,
      'label' => $title,
    ] = $preview->getPluginDefinition();

    if ($theme_name && $theme_name != $theme->getName()) {
      throw new NotFoundHttpException('The theme is not supported.');
    }

    $variation_id = $request->query->get('variation', 'default');
    if (!\is_string($variation_id) || !\array_key_exists($variation_id, $variations)) {
      throw new NotFoundHttpException('The variation does not exist.');
    }

    return [
      '#type' => 'page',
      '#title' => $title,
      'content' => [
        'preview' => [
          '#type' => 'container',
          '#attributes' => [
            'id' => 'ti-preview',
            'class' => ['ti-preview'],
          ],
          'content' => $preview->build($variation_id),
        ],
        'code' => ['#markup' => new FM('<code id="ti-code" hidden class="ti-code language-html"></code>', [])],
      ],
      '#attached' => [
        'library' => [
          'theme_inspector/preview_inner',
          // Load prism as "inner" library because we need to apply its CSS to
          // the iframe document.
          'theme_inspector/prism',
        ],
      ],
      '#cache' => ['max-age' => 0],
    ];
  }

}
