(function ($, Drupal, drupalSettings) {

  $.extend(Drupal.theme, {
    tableDragChangedWarning: function tableDragChangedWarning() {
      return '<div class="tabledrag-changed-warning alert message" role="alert">' + Drupal.theme('tableDragChangedMarker') + ' ' + Drupal.t('You have unsaved changes.') + '</div>';
    }
  });

})(jQuery, Drupal, drupalSettings);
