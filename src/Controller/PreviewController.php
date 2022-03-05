<?php declare(strict_types = 1);

namespace Drupal\theme_inspector\Controller;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Component\Render\FormattableMarkup as FM;
use Drupal\theme_inspector\ThemePreviewInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Returns responses for Theme Inspector routes.
 */
final class PreviewController {

  public function __invoke(Request $request, ThemePreviewInterface&PluginInspectionInterface $preview): array {

    $variations = $preview->getPluginDefinition()['variations'];
    $variation_id = $request->query->get('variation', 'default');
    if (!\is_string($variation_id) || !\array_key_exists($variation_id, $variations)) {
      throw new NotFoundHttpException('The variation does not exist.');
    }

    return [
      '#type' => 'page',
      '#title' => $preview->getPluginDefinition()['label'],
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
          // Load prism as "inner" library because we need to apply their CSS
          // to the iframe document.
          'theme_inspector/prism',
        ],
      ],
    ];
  }

}
