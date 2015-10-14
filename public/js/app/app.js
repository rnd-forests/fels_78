/**
 * Auto pagination using AJAX.
 * @param options
 */
$.fn.autoPagination = function (options) {
    var opts = $.extend({}, $.fn.autoPagination.defaults, options);
    var w = $(window),
        container = $(this),
        next = $(opts.nextAnchor),
        loader = $(opts.loader);
    w.on('scroll', function () {
        $(opts.paginator).addClass('hidden');
        if (next.attr('href') && w.scrollTop() + w.height() > next.offset().top - opts.buffer) {
            var url = next.attr('href');
            next.attr('href', '');
            loader.removeClass('hidden');
            $.get(url, function (data) {
                $(data).find(opts.item).each(function (index, element) {
                    $(element).insertAfter(container.find(opts.item).last());
                });
                loader.addClass('hidden');
                next.attr('href', $(data).find(opts.nextAnchor).attr('href'));
            });
        }
    });
};

$.fn.autoPagination.defaults = {
    buffer: 800,
    item: '.item',
    loader: '.loading',
    paginator: '.pagination',
    nextAnchor: '.pagination a[rel="next"]'
};

/**
 * Get Html of element included its container.
 * Source: https://css-tricks.com/snippets/jquery/outerhtml-jquery-plugin/
 * @returns {*}
 */
$.fn.outerHTML = function () {
    return (!this.length) ? this : (this[0].outerHTML || (function (el) {
        var div = document.createElement('div');
        div.appendChild(el.cloneNode(true));
        var contents = div.innerHTML;
        div = null;
        return contents;
    })(this[0]));
};

/**
 * AJAX call for follow / unfollow forms.
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

/**
 * Application scripts.
 * @type {{init}}
 */
var FELS = (function ($) {
    /**
     * Initialize all handlers/listeners/plugins.
     */
    var init = function () {
        _tooltips();
        _scrollTop();
        _followForm();
        _unfollowForm();
        _setupAjaxHeader();
        _storeTabPosition();
        _dismissibleAlerts();
        _autoPaginatedContent();
    };

    /**
     * Setup the AJAX.
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
     * @private
     */
    var _tooltips = function () {
        var $tooltips = $('[data-toggle=tooltip]');
        $tooltips.tooltip();
    };

    /**
     * Fade out alerts.
     * @private
     */
    var _dismissibleAlerts = function () {
        var $alerts = $('.alert').not('.alert-danger').not('.form-helper');
        $alerts.delay(2500).fadeOut();
    };

    /**
     * Store current position of tab in Bootstrap.
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
     * Follow user form.
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

    /**
     * Auto-loading table content using AJAX.
     * @private
     */
    var _autoPaginatedContent = function () {
        $('.auto-pagination').autoPagination();
    };

    /**
     * Trigger scroll top button.
     * @private
     */
    var _scrollTop = function () {
        var $button = $('#scroll-top');
        $button.on("click", function (event) {
            event.preventDefault();
            $('body, html').animate({scrollTop: 0}, 800);
        });
    };

    return {
        init: init
    };
})(jQuery);

$(function () {
    FELS.init();
});
