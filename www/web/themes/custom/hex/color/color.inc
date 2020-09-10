<?php

$background_color = '#ffffff';
$text_color = '#000000';

$info = [
  // Available colors and color labels used in theme.
  'fields' => [
    'primary' => t('Primary color'),
    'secondary' => t('Secondary color'),
    'active' => t('Active color'),
    'text' => t('Text color'),
  ],
  'schemes' => [
    'default' => [
      'title' => t('Default'),
      'colors' => [
        'primary' => '#111111',
        'secondary' => $background_color,
        'active' => '#f51167',
        'text' => $text_color,
      ],
    ],
    'red' => [
      'title' => t('Dark red'),
      'colors' => [
        'primary' => '#e54237',
        'secondary' => $background_color,
        'active' => '#a20f0f',
        'text' => $text_color,
      ]
    ],
    'green' => [
      'title' => t('Dark green'),
      'colors' => [
        'primary' => '#40c312',
        'secondary' => $background_color,
        'active' => '#296315',
        'text' => $text_color,
      ]
    ],
    'blue' => [
      'title' => t('Dark blue'),
      'colors' => [
        'primary' => '#0e5cc1',
        'secondary' => $background_color,
        'active' => '#280fa2',
        'text' => $text_color,
      ]
    ]
  ]
];

// CSS files (excluding @import) to rewrite with new color scheme.
$info['css'] = ['css/hc.color.css'];
