var FELS = (function ($) {
    /**
     * Initialize all handlers/listeners/plugins.
     */
    var init = function () {
        _tooltips();
        _setupAjaxHeader();
        _storeTabPosition();
        _dismissibleAlerts();
    };

    /**
     * Setup the AJAX.
     *
     * @private
     */
    var _setupAjaxHeader = function () {
        var $csrf = $('meta[name=csrf-token]');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $csrf.attr('content')
            }
        });
    };

    /**
     * Activate tooltips.
     *
     * @private
     */
    var _tooltips = function () {
        var $tooltips = $('[data-toggle=tooltip]');
        $tooltips.tooltip();
    };

    /**
     * Fade out alerts.
     *
     * @private
     */
    var _dismissibleAlerts = function () {
        var $alerts = $('.alert').not('.alert-danger').not('.notification');
        $alerts.delay(2500).fadeOut();
    };

    /**
     * Store current position of tab in Bootstrap.
     *
     * @private
     */
    var _storeTabPosition = function () {
        $('a[data-toggle=tab]').on('shown.bs.tab', function () {
            localStorage.setItem('lastTab', $(this).attr('href'));
        });
        var $last = localStorage.getItem('lastTab');
        if ($last) {
            $('[href=' + $last + ']').tab('show');
        }
    };

    return {
        init: init
    };
})(jQuery);

$(function () {
    FELS.init();
});