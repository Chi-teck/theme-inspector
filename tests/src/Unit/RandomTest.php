<?php declare(strict_types = 1);

namespace Drupal\Tests\theme_inspector\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\theme_inspector\Utility\Random;

/**
 * A test for Random utility.
 */
final class RandomTest extends UnitTestCase {

  public function testTitle() {
    $random = new Random();
    \mt_srand(8);

    // Random word count.
    self::assertSame('Kuwreclac', $random->title());
    self::assertSame('Lotruproua jiswipra wruthit', $random->title());
    self::assertSame('Hustidropo habastos', $random->title());

    // Explicit word count.
    self::assertSame('Maspos', $random->title(1));
    self::assertSame('Lojiguslo thiro clasweves', $random->title(3));
    self::assertSame('Noshidr tiphipri piliu jucruphus clasuspi', $random->title(5));

    \mt_srand();
  }

}
