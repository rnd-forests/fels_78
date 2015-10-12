/**
 * AJAX call for follow / unfollow forms.
 *
 * @param form
 * @param submit
 * @param inverse
 * @param stat
 */
function applyRelationship(form, submit, inverse, stat) {
    var promise = $.Deferred();
    $.ajax({
        data: form.serialize(),
        url: form.prop('action'),
        type: form.find('input[name="_method"]').val() || 'POST',
        beforeSend: function () {
            submit.attr('disabled', 'disabled');
            form.find('.fa').removeClass('hidden');
        },
        success: function () {
            promise.resolve(parseInt(stat.text().match(/\d+/).shift()));
            submit.removeAttr('disabled');
            form.find('.fa').addClass('hidden');
            form.wrap('<div class="hidden"></div>');
            inverse.unwrap();
        }
    });

    return promise;
}

var FELS = (function ($) {
    /**
     * Initialize all handlers/listeners/plugins.
     */
    var init = function () {
        _tooltips();
        _setupAjaxHeader();
        _storeTabPosition();
        _dismissibleAlerts();
        _followForm();
        _unfollowForm();
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
        var $alerts = $('.alert').not('.alert-danger');
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

    /**
     * Following user form.
     *
     * @private
     */
    var _followForm = function () {
        var $form = $('.follow-form'),
            $button = $form.find('.follow-button'),
            $inverse = $('.unfollow-form'),
            $stat = $('#followers');
        $form.on('submit', function (event) {
            event.preventDefault();
            var $promise = applyRelationship($(this), $button, $inverse, $stat);
            $promise.done(function (response) {
                var result = (response === 0)
                    ? (response + 1) + ' follower'
                    : (response + 1) + ' followers';
                $stat.html(result);
            });
        });
    };

    /**
     * Unfollow user form.
     *
     * @private
     */
    var _unfollowForm = function () {
        var $form = $('.unfollow-form'),
            $button = $form.find('.unfollow-button'),
            $inverse = $('.follow-form'),
            $stat = $('#followers');
        $form.on('submit', function (event) {
            event.preventDefault();
            var $promise = applyRelationship($(this), $button, $inverse, $stat);
            $promise.done(function (response) {
                var result = (response === 2)
                    ? (response - 1) + ' follower'
                    : (response - 1) + ' followers';
                $stat.html(result);
            });
        });
    };

    return {
        init: init
    };
})(jQuery);

$(function () {
    FELS.init();
});
