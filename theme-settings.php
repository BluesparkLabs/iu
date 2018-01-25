<?php

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function iu_form_system_theme_settings_alter(&$form, \Drupal\Core\Form\FormStateInterface &$form_state, $form_id = NULL) {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  $form['breadcrumbs'] = [
    '#type' => 'details',
    '#title' => t('Breadcrumb'),
    '#open' => TRUE,
  ];

  $form['breadcrumbs']['hide_home_breadcrumb'] = array(
    '#type' => 'radios',
    '#options' => [
      '0' => 'Show <em>Home</em> in breadcrumb trail (Drupal’s default behavior)',
      '1' => 'Remove <em>Home</em> from breadcrumb trail',
      '2' => 'Remove <em>Home</em> when it is the only breadcrumb in trail',
    ],
    '#default_value' => theme_get_setting('hide_home_breadcrumb', 'iu'),
  );

  $colors = _iu_secondary_color_palette_options();
  $options = [];

  foreach ($colors as $key => $color) {
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
