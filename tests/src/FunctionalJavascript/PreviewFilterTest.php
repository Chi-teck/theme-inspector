<?php declare(strict_types = 1);

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
      'Common (5)' => [
        'Details',
        'Page Title',
        'Progress Bar',
        'Status messages',
        'Table',
      ],
      'Navigation (5)' => [
        'Breadcrumbs',
        'Dropbutton',
        'More Link',
        'Pager',
        'Tabs',
      ],
      'Typography (5)' => [
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
      'Common (3)' => [
        'Details',
        'Progress Bar',
        'Status messages',
      ],
      'Navigation (2)' => [
        'Breadcrumbs',
        'Tabs',
      ],
      'Typography (2)' => [
        'Headings',
        'Lists',
      ],
    ];
    self::assertSame($expected_tree, $this->getTree());

    $page->fillField('Find preview', 'st');
    $expected_tree = [
      'Common (1)' => [
        'Status messages',
      ],
      'Typography (1)' => [
        'Lists',
      ],
    ];
    self::assertSame($expected_tree, $this->getTree());

    $page->fillField('Find preview', 'sta');
    $expected_tree = [
      'Common (1)' => [
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
    $groups = $this->getSession()->getPage()->findAll('css', '[data-ti-group]');
    foreach ($groups as $group) {
      $labels = $this->getVisibleLabels($group->findAll('css', 'a'));
      self::assertEquals($group->isVisible(), \count($labels) > 0);
      if ($group->isVisible()) {
        $tree[$group->find('css', 'summary')->getText()] = $labels;
      }
    }
    return $tree;
  }

  private function getVisibleLabels($links): array {
    // Links are rendered inside collapsed "details" elements. So that
    // `$node->isVisible()` is not suitable here.
    $is_shown = static fn (NodeElement $link): bool => !$link->getParent()->hasAttribute('hidden');
    $get_text = static fn (NodeElement $link): string => \trim($link->getHtml());
    return \array_values(\array_map($get_text, \array_filter($links, $is_shown)));
  }

}
