<?php

namespace Drupal\Tests\theme_inspector\FunctionalJavascript;

use Behat\Mink\Element\NodeElement;
use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

/**
 * Tests preview filter.
 *
 * @group theme_inspector
 */
final class PreviewFilterTest extends WebDriverTestBase {

  protected $defaultTheme = 'classy';

  protected static $modules = ['theme_inspector', 'theme_inspector_common'];

  public function testPreviewFilter(): void {

    $admin_user = $this->drupalCreateUser(['access theme inspector']);
    $this->drupalLogin($admin_user);
    $this->drupalGet('admin/appearance/theme-inspector');
    $page = $this->getSession()->getPage();

    $default_tree = [
      'COMMON' => [
        'Details',
        'Progress Bar',
        'Status messages',
        'Table',
      ],
      'NAVIGATION' => [
        'Breadcrumbs',
        'Pager',
        'Tabs',
      ],
      'TYPOGRAPHY' => [
        'Blockquote',
        'Headings',
        'Inline Text',
        'Lists',
        'Paragraph',
      ],
    ];

    $expected_tree = $default_tree;
    self::assertSame($expected_tree, $this->getTree());

    $page->fillField('Find preview', 's');
    $expected_tree = [
      'COMMON' => [
        'Details',
        'Progress Bar',
        'Status messages',
      ],
      'NAVIGATION' => [
        'Breadcrumbs',
        'Tabs',
      ],
      'TYPOGRAPHY' => [
        'Headings',
        'Lists',
      ],
    ];
    self::assertSame($expected_tree, $this->getTree());

    $page->fillField('Find preview', 'st');
    $expected_tree = [
      'COMMON' => [
        'Status messages',
      ],
      'TYPOGRAPHY' => [
        'Lists',
      ],
    ];
    self::assertSame($expected_tree, $this->getTree());

    $page->fillField('Find preview', 'sta');
    $expected_tree = [
      'COMMON' => [
        'Status messages',
      ],
    ];
    self::assertSame($expected_tree, $this->getTree());

    $page->fillField('Find preview', 'stan');
    $expected_tree = [];
    self::assertSame($expected_tree, $this->getTree());

    $page->fillField('Find preview', '');
    $expected_tree = $default_tree;
    self::assertSame($expected_tree, $this->getTree());
  }

  private function getTree(): array {
    $tree = [];
    $headers = $this->getSession()->getPage()->findAll('css', 'h3[data-ti-category-header]');
    foreach ($headers as $header) {
      $labels = $this->getVisibleLabels(
        $header->findAll('xpath', '/following-sibling::ul[1]/li/a'),
      );
      self::assertEquals($header->isVisible(), \count($labels) > 0);
      if ($header->isVisible()) {
        $tree[$header->getText()] = $labels;
      }
    }
    return $tree;
  }

  private function getVisibleLabels($links): array {
    $is_visible = static fn (NodeElement $link): string => $link->isVisible();
    $get_text = static fn (NodeElement $link): string => $link->getText();
    return \array_values(\array_map($get_text, \array_filter($links, $is_visible)));
  }

}
