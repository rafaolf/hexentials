<?php

$primary_color = '#111111';
$secondary_color = '#222222';
$active_color = '#f51167';
$background_color = '#ffffff';
$top_menu_item_color = '#333333';
$footer_menu_item_color = '#444444';
$text_color = '#000000';

$info = [
  // Available colors and color labels used in theme.
  'fields' => [
    'primary' => t('Primary color'),
    'secondary' => t('Secondary color'),
    'active' => t('Active item color'),
    'background' => t('Background color'),
    'top_menu_item' => t('Top menu item color'),
    'footer_menu_item' => t('Footer menu item color'),
    'text' => t('Text color'),
  ],
  'schemes' => [
    'default' => [
      'title' => t('Default'),
      'colors' => [
        'primary' => $primary_color,
        'secondary' => $secondary_color,
        'active' => $active_color,
        'background' => $background_color,
        'top_menu_item' => $top_menu_item_color,
        'footer_menu_item' => $footer_menu_item_color,
        'text' => $text_color,
      ],
    ],
    'flexi_cart' => [
      'title' => t('Flexi Cart'),
      'colors' => [
        'primary' => $primary_color,
        'secondary' => $secondary_color,
        'active' => $active_color,
        'background' => $background_color,
        'top_menu_item' => $primary_color,
        'footer_menu_item' => $background_color,
        'text' => $text_color,
      ],
    ],
    'red' => [
      'title' => t('Dark red'),
      'colors' => [
        'primary' => '#a20f0f',
        'secondary' => $secondary_color,
        'active' => '#e54237',
        'background' => $text_color,
        'top_menu_item' => $background_color,
        'footer_menu_item' => $background_color,
        'text' => $background_color,
      ]
    ],
    'green' => [
      'title' => t('Dark green'),
      'colors' => [
        'primary' => '#296315',
        'secondary' => $secondary_color,
        'active' => '#40c312',
        'background' => $text_color,
        'top_menu_item' => $background_color,
        'footer_menu_item' => $background_color,
        'text' => $background_color,
      ]
    ],
    'blue' => [
      'title' => t('Dark blue'),
      'colors' => [
        'primary' => '#0f0fa2',
        'secondary' => $secondary_color,
        'active' => '#13c7bb',
        'background' => $text_color,
        'top_menu_item' => $background_color,
        'footer_menu_item' => $background_color,
        'text' => $background_color,
      ]
    ]
  ],
  'css' => ['css/hc.color.css'],
  'copy' => ['logo.svg']
];
