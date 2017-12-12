<?php

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function iu_form_system_theme_settings_alter(&$form, \Drupal\Core\Form\FormStateInterface &$form_state, $form_id = NULL) {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  $options = [
    'crimson' => [
      'name'=>'Crimson',
      'hex' => '#990000',
      'class' => 'bg-crimson bg-dark',
    ],
    'mahogany' => [
      'name'=>'Mahogany',
      'hex' => '#4a3c31',
      'class' => 'bg-mahogany bg-dark',
    ],
    'gold-dark' => [
      'name'=>'Dark Gold',
      'hex' => '#dc8823',
      'class' => 'bg-gold-dark',
    ],
    'gold' => [
      'name'=>'Gold',
      'hex' => '#f1be48',
      'class' => 'bg-gold',
    ],
    'mint-dark' => [
      'name'=>'Dark Mint',
      'hex' => '#285c4d',
      'class' => 'bg-mint-dark bg-dark',
    ],
    'mint' => [
      'name'=>'Mint',
      'hex' => '#008264',
      'class' => 'bg-mint bg-dark',
    ],
    'midnight-dark' => [
      'name'=>'Dark Midnight',
      'hex' => '#01426a',
      'class' => 'bg-midnight-dark bg-dark',
    ],
    'midnight' => [
      'name'=>'Midnight',
      'hex' => '#006298',
      'class' => 'bg-midnight bg-dark',
    ],
    'majestic-dark' => [
      'name'=>'Dark Majestic',
      'hex' => '#512a44',
      'class' => 'bg-majestic-dark bg-dark',
    ],
    'majestic' => [
      'name'=>'Majestic',
      'hex' => '#66435a',
      'class' => 'bg-majestic bg-dark',
    ],
    'limestone-dark' => [
      'name'=>'Dark Limestone',
      'hex' => '#83786f',
      'class' => 'bg-limestone-dark bg-dark',
    ],
    'limestone' => [
      'name'=>'Limestone',
      'hex' => '#aca39a',
      'class' => 'bg-limestone',
    ],
    'black' => [
      'name'=>'Black',
      'hex' => '#191919',
      'class' => 'bg-black bg-dark',
    ],
    'gray' => [
      'name'=>'Light Gray',
      'hex' => '#edebeb',
      'class' => 'bg-gray',
    ],
  ];

  foreach ($options as $key => $color) {
    $options[$key] = '
<div class="color-block '. $color['class'] . '">
  <div class="color-name">' . $color['name'] . '</div>
  <div class="color-details">HEX: '. $color['hex'] .'</div>
</div>
    ';
  }

  $form['secondary_color'] = [
    '#type' => 'radios',
    '#title' => t('Secondary background color (for sections)'),
    '#options' => $options,
    '#attributes' => ['class' => ['color-block-radios']],
    '#default_value' => theme_get_setting('secondary_color', 'iu'),
    '#description'   => t("In addition to the two primary background colors (crimson and light gray) available for use in your site sections, you may also select one additional secondary background color from the expanded IU Color Palette. Note: Crimson is Indiana University's main brand color and should always be used in greater frequency than any secondary color."),
    '#attached' => ['library' => ['iu/color-block']],
   ];
}
