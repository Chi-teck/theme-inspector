<?php declare(strict_types = 1);

namespace Drupal\theme_inspector_common\Plugin\ThemePreview\Typography;

use Drupal\theme_inspector\ThemePreviewPluginBase;

/**
 * Inline text preview.
 *
 * @ThemePreview(
 *   id = "inline_text",
 *   label = @Translation("Inline Text"),
 *   category = @Translation("Typography"),
 * )
 */
final class InlineText extends ThemePreviewPluginBase {

  public function build(string $variation): array {
    $markup = <<< 'HTML'
      <p>You can use the mark tag to <mark>highlight</mark> text.</p>
      <p><del>This line of text is meant to be treated as deleted text.</del></p>
      <p><s>This line of text is meant to be treated as no longer accurate.</s></p>
      <p><ins>This line of text is meant to be treated as an addition to the document.</ins></p>
      <p><u>This line of text will render as underlined</u></p>
      <p><small>This line of text is meant to be treated as fine print.</small></p>
      <p><strong>This line rendered as bold text.</strong></p>
      <p><em>This line rendered as italicized text.</em></p>
      <p>This line includes some <code>code</code>.</p>
      HTML;
    return ['#markup' => $markup];
  }

}
