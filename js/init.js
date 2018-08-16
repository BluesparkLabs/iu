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

        // Account for absolutely positioned elements when animating a scroll effect.
        IU.uiDisplace = function() {

            // Account for IU Framework's sticky nav or branding bar, and bigNav setting.
            var displace = (IU.settings.bigNav) ? 68 : 55;

            // Account for Drupal Toolbar.
            if ($('body').hasClass('toolbar-fixed')) {
                displace += 39;
            }
            // Account for Drupal Toolbar tray.
            if ($('body').hasClass('toolbar-tray-open')
                && $('body').hasClass('toolbar-horizontal')) {
                displace += 40;
            }
            return displace;
        };

        // Override default smoothScroll helper to integrate with Drupal Toolbar.
        IU.addHelper('smoothScroll', function() {
            var scope = this;

            $('a[href*="#"]:not([href="#"], [href^="#panel"])').not('#skipnav a').click(function() {
                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top - IU.uiDisplace()
                        }, 1000);

                        return false;
                    }
                }
            });
        });


        // Override default skipNav helper to integrate with Drupal Toolbar.
        IU.addHelper('skipNav', function() {
            var scope = this;

            $("#skipnav a").on('click', function(event) {
                var target = $(this.hash);

                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - IU.uiDisplace(),
                    }, 500);

                    target.attr('tabindex', 0).on('blur focusout', function () {
                        $(this).removeAttr('tabindex');
                    }).focus();

                    if (target.attr('id') === 'search') {
                        $("#toggles a.search-toggle")[0].click();
                        return;
                    }
                    else if (target.attr('id') === 'nav-main' && IU.$window.width() < 1025 ) {
                        $('#toggles [data-toggle]').click();
                        return;
                    }
                }
            });
        });
    });
})(jQuery, window, window.document);
