<?php
/**
 * @file
 * Enables modules and site configuration for a standard site installation.
 */

// Add any custom code here like hook implementations.

function hex_commerce_preprocess_page(&$variables) {
  $config = \Drupal::config('hex_commerce.settings');

  foreach (\Drupal::theme()->getActiveTheme()->getRegions() as $region) {
    if (!isset($variables['phone'])) {
      $variables['phone'] = \Drupal::config('hex_commerce.settings')->get('phone');
    }
  }
}
