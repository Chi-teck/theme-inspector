<?php

/**
 * @file
 * Hooks specific to the Snippet manager module.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Perform alterations on Field API field types.
 *
 * @param array $info
 *   Array of information on theme previews as collected by the "theme preview"
 *   plugin manager.
 */
function hook_theme_preview_info_alter(array &$info): void {
  $info['example']['category'] = t('My Category');
}

/**
 * Defines theme preview definitions.
 *
 * This hook can only be implemented by themes. Modules can provide preview
 * through plugins.
 *
 * Callback example.
 * @code
 * function _my_theme_example(string $variation): array {
 *   return ['#markup' => t('Preview for @variation', ['@variation' => $variation])];
 * }
 * @endcode
 *
 * @return array
 *   Theme preview definitions.
 */
function hook_theme_preview_info(): array {

  $info['example'] = [
    'label' => 'Example',
    'category' => 'My Theme',
    'variations' => [
      'alpha' => 'Alpha',
      'beta' => 'Beta',
    ],
    'callback' => '_my_theme_example',
  ];

  return $info;
}

/**
 * @} End of "addtogroup hooks".
 */
