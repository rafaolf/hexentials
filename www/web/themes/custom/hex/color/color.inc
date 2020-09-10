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
    'red' => [
      'title' => t('Dark red'),
      'colors' => [
        'primary' => '#e54237',
        'secondary' => $secondary_color,
        'active' => '#a20f0f',
        'background' => $background_color,
        'top_menu_item' => $top_menu_item_color,
        'footer_menu_item' => $footer_menu_item_color,
        'text' => $text_color,
      ]
    ],
    'green' => [
      'title' => t('Dark green'),
      'colors' => [
        'primary' => '#40c312',
        'secondary' => $secondary_color,
        'active' => '#296315',
        'background' => $background_color,
        'top_menu_item' => $top_menu_item_color,
        'footer_menu_item' => $footer_menu_item_color,
        'text' => $text_color,
      ]
    ],
    'blue' => [
      'title' => t('Dark blue'),
      'colors' => [
        'primary' => '#0e5cc1',
        'secondary' => $secondary_color,
        'active' => '#280fa2',
        'background' => $background_color,
        'top_menu_item' => $top_menu_item_color,
        'footer_menu_item' => $footer_menu_item_color,
        'text' => $text_color,
      ]
    ]
  ],
  'css' => ['css/hc.color.css'],
  'copy' => ['logo.svg']
];
