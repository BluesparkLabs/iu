<?php
/**
 * @file
 * Add custom theme settings to the IU Framework theme.
 */

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function iu_form_system_theme_settings_alter(&$form, FormStateInterface &$form_state, $form_id = NULL) {
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
    '#default_value' => theme_get_setting('hide_home_breadcrumb'),
  );

  $form['off_canvas'] = [
    '#type' => 'details',
    '#title' => t('Mobile menu position'),
    '#open' => TRUE,
  ];

  $off_canvas_position = theme_get_setting('off_canvas_position') ?: 'right';
  $form['off_canvas']['off_canvas_position'] = array(
    '#type' => 'radios',
    '#options' => [
      'right' => 'Slide in from right side (IU Framework’s default behavior)',
      'left' => 'Slide in from left side',
    ],
    '#default_value' => $off_canvas_position,
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

  $form['color_palette'] = [
    '#type' => 'details',
    '#title' => t('Color palette'),
    '#open' => TRUE,
  ];

  $form['color_palette']['secondary_color'] = [
    '#type' => 'radios',
    '#title' => t('Secondary background color (for sections)'),
    '#options' => $options,
    '#attributes' => ['class' => ['color-block-radios']],
    '#default_value' => theme_get_setting('secondary_color'),
    '#description'   => t("In addition to the two primary background colors (crimson and light gray) available for use in your site sections, you may also select one additional secondary background color from the expanded IU Color Palette. Note: Crimson is Indiana University's main brand color and should always be used in greater frequency than any secondary color."),
    '#attached' => ['library' => ['iu/color-block']],
  ];

  $form['#validate'][] = 'iu_form_system_theme_settings_validate';
  $form['#submit'][] = 'iu_form_system_theme_settings_submit';
}

/**
 * Form vallidation handler for system_theme_settings form.
 */
function iu_form_system_theme_settings_validate($form, FormStateInterface $form_state) {
  // Set a flag to indicate whether caches need to be cleared.
  $flush_caches = FALSE;
  $settings = [
    [
      'color_palette',
      'secondary_color',
    ],
    [
      'off_canvas',
      'off_canvas_position',
    ],
  ];
  foreach ($settings as $setting) {
    $original_value = NestedArray::getValue($form, array_merge($setting, ['#default_value']), $key_exists);
    if ($key_exists) {
      $submitted_value = $form_state->getValue(array_pop($setting));
      if ($submitted_value !== $original_value) {
        $flush_caches = TRUE;
        break;
      }
    }
  }
  $form_state->set('flush_caches', $flush_caches);
}

/**
 * Form submission handler for system_theme_settings form.
 */
function iu_form_system_theme_settings_submit($form, FormStateInterface $form_state) {
  // Clear cached data so a change will take effect.
  if ($form_state->get('flush_caches')) {
    drupal_flush_all_caches();
  }
}
