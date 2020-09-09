<?php

$info = [
  // Available colors and color labels used in theme.
  'fields' => [
    'primary' => t('Primary color'),
    'secondary' => t('Secondary color (highlighted)'),
    'main_menu' => t('Main menu color'),
    'footer_menu' => t('Footer menu color'),
    'background' => t('Background color'),
    'text' => t('Text color'),
  ],
  'schemes' => [
    'default' => [
      'title' => t('Default'),
      'colors' => [
        'primary' => '#111111',
        'secondary' => '#f51167',
        'main_menu' => '#111111',
        'footer_menu' => '#ffffff',
        'background' => '#ffffff',
        'text' => '#111111',
      ],
    ],
    'red' => [
      'title' => t('Red'),
      'colors' => [
        'primary' => '#f44336',
        'secondary' => '#ffcdd2',
        'main_menu' => '#f44336',
        'footer_menu' => '#f44336',
        'background' => '#ffffff',
        'text' => '#600000',
      ]
    ]
  ]
];

// CSS files (excluding @import) to rewrite with new color scheme.
$info['css'] = ['css/hc.color.css'];
