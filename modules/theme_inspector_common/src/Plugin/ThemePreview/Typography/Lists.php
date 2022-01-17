<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview\Typography;

use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * A preview plugin for HTML lists.
 *
 * @ThemePreview(
 *   id = "lists",
 *   label = @Translation("Lists"),
 *   category = @Translation("Typography"),
 *   variations = {
 *     "unordered" = @Translation("Unordered"),
 *     "ordered" = @Translation("Ordered"),
 *     "definition" = @Translation("Definition"),
 *   },
 * )
 */
final class Lists extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    if ($variation === 'definition') {
      $build['#markup'] = <<< 'HTML'
        <dl>
          <dt>Beast of Bodmin</dt>
          <dd>A large feline inhabiting Bodmin Moor.</dd>
          <dt>Morgawr</dt>
          <dd>A sea serpent.</dd>
          <dt>Owlman</dt>
          <dd>A giant owl-like creature.</dd>
        </dl>
        HTML;
    }
    else {
      $build = [
        '#theme' => 'item_list',
        '#title' => 'My List',
        '#list_type' => $variation === 'ordered' ? 'ol' : 'ul',
        '#items' => ['Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5'],
      ];
    }
    return $build;
  }

}
