// Auto pagination using AJAX.
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

// Get Html of element included its container.
// Source: https://css-tricks.com/snippets/jquery/outerhtml-jquery-plugin/
$.fn.outerHTML = function () {
    return (!this.length) ? this : (this[0].outerHTML || (function (el) {
        var div = document.createElement('div');
        div.appendChild(el.cloneNode(true));
        var contents = div.innerHTML;
        div = null;
        return contents;
    })(this[0]));
};

// AJAX call for follow / unfollow forms.
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

// Generate a random UUID.
// Source: http://jsfiddle.net/briguy37/2mvfd/
function generateUUID() {
    var date = (new Date).getTime();
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = (date + Math.random() * 16) % 16 | 0;
        date = Math.floor(date / 16);
        return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
}

var FELS = (function ($) {
    var init = function () {
        _global();
        _wordForm();
        _followForm();
        _unfollowForm();
        _updateWordForm();
        _deleteWordForm();
        _storeTabPosition();
        _deleteAnswerFrom();
        _updateAnswerForm();
    };

    // Global configurations.
    var _global = function () {
        // Set AJAX header.
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
            }
        });

        // Scroll-top button.
        $('#scroll-top').on('click', function (event) {
            event.preventDefault();
            $('body, html').animate({scrollTop: 0}, 800);
        });

        // Toggle content button.
        $('.content-toggle').on('click', function () {
            $(this).toggleClass('fa-arrow-circle-up fa-arrow-circle-down');
        });

        // Select2 plugin.
        var $selector = $('.select2-selection');
        $selector.select2({
            placeholder: $selector.data('description')
        });

        $('[data-toggle=tooltip]').tooltip();
        $('.auto-pagination').autoPagination();
        $('.alert').not('.alert-danger').not('.form-helper').delay(2500).fadeOut();
    };

    // Store current position of tab in Bootstrap.
    var _storeTabPosition = function () {
        $('a[data-toggle=tab]').on('shown.bs.tab', function () {
            localStorage.setItem('lastTab', $(this).attr('href'));
        });
        var $last = localStorage.getItem('lastTab');
        if ($last) {
            $('[href=' + $last + ']').tab('show');
        }
    };

    // Follow user form.
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

    // Unfollow user form.
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

    // Word creation form.
    var _wordForm = function () {
        var $minField = 4,
            $maxField = 10,
            $container = $('.word-answers'),
            $form = $container.closest('form'),
            $field = $container.find('.answer'),
            $fieldHtml = $field.outerHTML() + '';

        $field.remove();
        var replaceFieldHtml = function () {
            var $uuid = generateUUID();
            return $fieldHtml.replace(/word\[answers]\[\d+]/g, 'word[answers][' + $uuid + ']');
        };
        for (var i = 0; i < $minField; i++) {
            $container.append(replaceFieldHtml());
        }
        $container.on('click', '.add-button', function (event) {
            event.preventDefault();
            if ($minField < $maxField) {
                $container.append(replaceFieldHtml());
                $minField++;
            }
        });
        $container.on('click', '.remove-button', function (event) {
            event.preventDefault();
            if ($minField > 4) {
                $(this).closest('.answer').remove();
                $minField--;
            }
        });
        $container.on('change', '.correct input', function () {
            var $checkboxes = $container.find('.correct input'),
                $currentCheckbox = $(this);
            $checkboxes.not($currentCheckbox).prop('checked', false);
            $checkboxes.filter(':checked').prev().remove();

            var $formGroup = $currentCheckbox.closest('.form-group');
            $formGroup.addClass('has-success');

            var a = $checkboxes.not($currentCheckbox).closest('.form-group');
            a.removeClass('has-success');
        });
        $form.on('submit', function (event) {
            if ($container.find('.correct input').filter(':checked').length === 0) {
                event.preventDefault();
                swal({
                    title: "Opps!",
                    text: "You need to mark one answer as correct",
                    type: 'warning',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    };

    // Delete answer form.
    var _deleteAnswerFrom = function () {
        $('.delete-answer-form').on('submit', function (event) {
            event.preventDefault();
            var form = $(this);
            $.ajax({
                data: form.serialize(),
                url: form.prop('action'),
                type: form.find('input[name="_method"]').val() || 'POST',
                success: function () {
                    form.closest('.list-group-item').remove();
                }
            });
        });
    };

    // Update answer form.
    var _updateAnswerForm = function () {
        $('.answer-update-form').on('submit', function (event) {
            event.preventDefault();
            var form = $(this);
            $.ajax({
                data: form.serialize(),
                url: form.prop('action'),
                type: form.find('input[name="_method"]').val() || 'POST',
                success: function () {
                    form.closest('.list-group-item')
                        .find('.solution')
                        .text(form.find('input[name=solution]').val());
                }
            });
        });
    };

    // Update word form.
    var _updateWordForm = function () {
        $('.word-update-form').on('submit', function (event) {
            event.preventDefault();
            var form = $(this);
            $.ajax({
                data: form.serialize(),
                url: form.prop('action'),
                type: form.find('input[name="_method"]').val() || 'POST',
                success: function () {
                    form.closest('.list-group-item')
                        .find('.word-content')
                        .text(form.find('input[name=content]').val());
                }
            });
        });
    };

    // Delete word form.
    var _deleteWordForm = function () {
        $('.delete-word-form').on('submit', function (event) {
            event.preventDefault();
            var form = $(this);
            $.ajax({
                data: form.serialize(),
                url: form.prop('action'),
                type: form.find('input[name="_method"]').val() || 'POST',
                success: function () {
                    form.closest('.word').slideUp();
                }
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
