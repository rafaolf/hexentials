<?php
/**
 * @file
 * Enables modules and site configuration for a standard site installation.
 */

// Add any custom code here like hook implementations.

function hex_commerce_preprocess_page(&$variables) {
  // Make the phone available to all pages.
  $config = \Drupal::config('hex.settings');

  foreach (\Drupal::theme()->getActiveTheme()->getRegions() as $region) {
    if (!isset($variables['phone'])) {
      $variables['phone'] = $config->get('phone');
    }
  }
}
