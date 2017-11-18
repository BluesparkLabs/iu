/*!
 * Initialize IU JS
 */
(function($, window, document, undefined) {
    $(document).ready(function() {

        Foundation.OffCanvas.defaults.transitionTime = 500;
        Foundation.OffCanvas.defaults.forceTop = false;
        Foundation.OffCanvas.defaults.positiong = 'right';

        Foundation.Accordion.defaults.multiExpand = true;
        Foundation.Accordion.defaults.allowAllClosed = true;

        // Initialize Foundation
        $(document).foundation();

        var IU = window.IU || {};

        // Delete modules if necessary
        // delete IU.uiModules['accordion'];

        IU.init && IU.init();
    });
})(jQuery, window, window.document);
