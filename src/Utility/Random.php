<?php declare(strict_types = 1);

namespace Drupal\theme_inspector\Utility;

use Drupal\Component\Utility\Random as CoreRandom;

/**
 * Defines a utility class for creating random data.
 */
final class Random extends CoreRandom {

  public function title(?int $word_count = NULL): string {
    $words = \array_map(
      fn(): string => $this->word(\mt_rand(5, 10)),
      \array_fill(1, $word_count ?? mt_rand(1, 3), NULL),
    );
    return \ucfirst(\implode(' ', $words));
  }

}
