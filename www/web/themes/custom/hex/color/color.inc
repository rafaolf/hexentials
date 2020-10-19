<?php

$primary = '#111111';
$active = '#f51167';
$shadow = '#dadce0';
$hover = '#f51144';
$hover_background = '#f0e9e9';
$background = '#ffffff';
$view = '#a92727';
$top_menu_item = '#333333';
$header_second = '#222222';
$footer_menu_item = '#444444';
$text = '#000000';

$info = [
  // Available colors and color labels used in theme.
  'fields' => [
    'primary' => t('Primary'),
    'active' => t('Active item'),
    'shadow' => t('Shadow'),
    'hover' => t('Hover'),
    'hover_background' => t('Hover background'),
    'background' => t('Background'),
    'view' => t('Views'),
    'top_menu_item' => t('Top menu item'),
    'header_second' => t('Header second'),
    'footer_menu_item' => t('Footer menu item'),
    'text' => t('Text'),
  ],
  'schemes' => [
    'default' => [
      'title' => t('Default'),
      'colors' => [
        'primary' => $primary,
        'active' => $active,
        'shadow' => $shadow,
        'hover' => $hover,
        'hover_background' => $hover_background,
        'background' => $background,
        'view' => $view,
        'top_menu_item' => $top_menu_item,
        'header_second' => $header_second,
        'footer_menu_item' => $footer_menu_item,
        'text' => $text,
      ],
    ],
    'flexi_cart' => [
      'title' => t('Flexi Cart'),
      'colors' => [
        'primary' => $primary,
        'active' => $active,
        'shadow' => $shadow,
        'hover' => $active,
        'hover_background' => $background,
        'background' => $background,
        'view' => $background,
        'top_menu_item' => $text,
        'header_second' => $background,
        'footer_menu_item' => $background,
        'text' => $text,
      ],
    ],
    'red' => [
      'title' => t('Dark red'),
      'colors' => [
        'primary' => '#a20f0f',
        'active' => '#e54237',
        'shadow' => $shadow,
        'hover' => '#e54237',
        'hover_background' => $background,
        'background' => $text,
        'view' => $text,
        'top_menu_item' => $text,
        'header_second' => $background,
        'footer_menu_item' => $background,
        'text' => $background,
      ]
    ],
    'green' => [
      'title' => t('Dark green'),
      'colors' => [
        'primary' => '#296315',
        'active' => '#40c312',
        'shadow' => $shadow,
        'hover' => '#40c312',
        'hover_background' => $background,
        'background' => $text,
        'view' => $text,
        'top_menu_item' => $text,
        'header_second' => $background,
        'footer_menu_item' => $background,
        'text' => $background,
      ]
    ],
    'blue' => [
      'title' => t('Dark blue'),
      'colors' => [
        'primary' => '#0f0fa2',
        'active' => '#13c7bb',
        'shadow' => $shadow,
        'hover' => '#13c7bb',
        'hover_background' => $background,
        'background' => $text,
        'view' => $text,
        'top_menu_item' => $text,
        'header_second' => $background,
        'footer_menu_item' => $background,
        'text' => $background,
      ]
    ]
  ],
  'css' => ['css/hc.color.css'],
  'copy' => ['logo.svg']
];
