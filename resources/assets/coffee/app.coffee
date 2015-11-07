$.fn.infiniteScroll = (options) ->
  opts = $.extend({}, $.fn.infiniteScroll.defaults, options)
  w = $(window)
  container = $(this)
  next = $(opts.nextLink)
  loading = $(opts.loading)
  w.on 'scroll', ->
    $(opts.paginator).addClass 'hidden'
    if next.attr('href') and w.scrollTop() + w.height() > next.offset().top - (opts.buffer)
      url = next.attr('href')
      next.attr 'href', ''
      loading.removeClass 'hidden'
      $.get url, (data) ->
        $(data).find(opts.item).each (idx, el) ->
          $(el).insertAfter container.find(opts.item).last()
        loading.addClass 'hidden'
        next.attr 'href', $(data).find(opts.nextLink).attr('href')

$.fn.infiniteScroll.defaults =
  buffer: 800
  item: '.item'
  loading: '.loading'
  paginator: '.pagination'
  nextLink: '.pagination a[rel="next"]'


# Source: https://css-tricks.com/snippets/jquery/outerhtml-jquery-plugin/
$.fn.outerHTML = ->
  if !@length then this else @[0].outerHTML or ((el) ->
    div = document.createElement('div')
    div.appendChild el.cloneNode(true)
    contents = div.innerHTML
    div = null
    contents)(@[0])


createRelationship = (form, submit, inverse, stat) ->
  promise = $.Deferred()
  $.ajax
    data: form.serialize()
    url: form.prop('action')
    type: form.find('input[name="_method"]').val() or 'post'
    beforeSend: ->
      submit.prop 'disabled', true
      form.find('.fa').removeClass 'hidden'
    success: ->
      promise.resolve parseInt(stat.text().match(/\d+/).shift())
      submit.prop 'disabled', false
      form.find('.fa').addClass 'hidden'
      form.wrap '<div class="hidden"></div>'
      inverse.unwrap()
  promise


# Source: http://jsfiddle.net/briguy37/2mvfd/
generateUUID = ->
  date = (new Date).getTime()
  'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace /[xy]/g, (c) ->
    r = (date + Math.random() * 16) % 16 | 0
    date = Math.floor(date / 16)
    (if c == 'x' then r else r & 0x3 | 0x8).toString 16


FELS = (($) ->
  init = ->
    _global()
    _lesson()
    _searchForm()
    _followForm()
    _unfollowForm()
    _filterWordForm()
    _createWordForm()
    _updateWordForm()
    _deleteWordForm()
    _storeTabPosition()
    _deleteAnswerForm()
    _updateAnswerForm()


  # Global configurations.
  _global = ->
    $.ajaxSetup headers:
      'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')

    $('#scroll-top').on 'click', (e) ->
      e.preventDefault()
      $('body, html').animate {scrollTop: 0}, 800

    $('.content-toggle').on 'click', ->
      $(this).toggleClass 'fa-arrow-circle-up fa-arrow-circle-down'

    $selector = $('.select2-selection')
    $selector.select2 placeholder: $selector.data('description')

    $('[data-toggle=tooltip]').tooltip()
    $('.auto-pagination').infiniteScroll()
    $('.alert').not('.alert-danger').not('.form-helper').delay(2500).fadeOut()

  _storeTabPosition = ->
    $('a[data-toggle=tab]').on 'shown.bs.tab', ->
      localStorage.setItem 'lastTab', $(this).attr('href')
    $last = localStorage.getItem('lastTab')
    if $last
      $('[href=' + $last + ']').tab 'show'

  _followForm = ->
    $form = $('.follow-form')
    $button = $form.find('.follow-button')
    $inverse = $('.unfollow-form')
    $stat = $('#followers')
    $form.on 'submit', (e) ->
      e.preventDefault()
      $promise = createRelationship($(this), $button, $inverse, $stat)
      $promise.done (response) ->
        result = if response == 0 then response + 1 + ' follower' else response + 1 + ' followers'
        $stat.html result

  _unfollowForm = ->
    $form = $('.unfollow-form')
    $button = $form.find('.unfollow-button')
    $inverse = $('.follow-form')
    $stat = $('#followers')
    $form.on 'submit', (e) ->
      e.preventDefault()
      $promise = createRelationship($(this), $button, $inverse, $stat)
      $promise.done (response) ->
        result = if response == 2 then response - 1 + ' follower' else response - 1 + ' followers'
        $stat.html result

  _createWordForm = ->
    $minField = 4
    $maxField = 10
    $container = $('.word-answers')
    $form = $container.closest('form')
    $field = $container.find('.answer')
    $fieldHtml = $field.outerHTML() + ''
    $field.remove()
    replaceFieldHtml = ->
      $uuid = generateUUID()
      $fieldHtml.replace /word\[answers]\[\d+]/g, 'word[answers][' + $uuid + ']'
    i = 0
    while i < $minField
      $container.append replaceFieldHtml()
      i++
    $container.on 'click', '.add-button', (e) ->
      e.preventDefault()
      if $minField < $maxField
        $container.append replaceFieldHtml()
        $minField++
    $container.on 'click', '.remove-button', (e) ->
      e.preventDefault()
      if $minField > 4
        $(this).closest('.answer').remove()
        $minField--
    $container.on 'change', '.correct input', ->
      $checkboxes = $container.find('.correct input')
      $currentCheckbox = $(this)
      $checkboxes.not($currentCheckbox).prop 'checked', false
      $checkboxes.filter(':checked').prev().remove()
      $formGroup = $currentCheckbox.closest('.form-group')
      $formGroup.addClass 'has-success'
      a = $checkboxes.not($currentCheckbox).closest('.form-group')
      a.removeClass 'has-success'
    $form.on 'submit', (e) ->
      if $container.find('.correct input').filter(':checked').length == 0
        e.preventDefault()
        swal
          title: 'Opps!'
          text: 'You need to mark one answer as correct'
          type: 'warning'
          timer: 1500
          showConfirmButton: false

  _deleteAnswerForm = ->
    $('.word--form__delete-answer').on 'submit', (e) ->
      e.preventDefault()
      form = $(this)
      $.ajax
        data: form.serialize()
        url: form.prop('action')
        type: form.find('input[name="_method"]').val() or 'POST'
        success: ->
          form.closest('.list-group-item').remove()

  _updateAnswerForm = ->
    $('.word--form__update-answer').on 'submit', (e) ->
      e.preventDefault()
      form = $(this)
      $.ajax
        data: form.serialize()
        url: form.prop('action')
        type: form.find('input[name="_method"]').val() or 'POST'
        success: ->
          form.closest('.list-group-item').find('.solution').text form.find('input[name=solution]').val()

  _updateWordForm = ->
    $('.word--form__update-word').on 'submit', (e) ->
      e.preventDefault()
      form = $(this)
      $.ajax
        data: form.serialize()
        url: form.prop('action')
        type: form.find('input[name="_method"]').val() or 'POST'
        success: ->
          form.closest('.word').find('.word-content').text form.find('input[name=content]').val()

  _deleteWordForm = ->
    $('.word--form__delete-word').on 'submit', (e) ->
      e.preventDefault()
      form = $(this)
      $.ajax
        data: form.serialize()
        url: form.prop('action')
        type: form.find('input[name="_method"]').val() or 'POST'
        success: ->
          form.closest('.word').slideUp()

  _searchForm = ->
    $('#search-form').on('input', '#keyword', ->
      $keyword = $.trim($(this).val())
      if !$keyword or $keyword.length == 0
        $(this).popover 'toggle'
      else
        $(this).popover 'hide'
    ).on 'submit', ->
      $box = $('#keyword')
      $keyword = $.trim($box.val())
      if !$keyword or $keyword.length == 0
        $('#search-keyword-modal').modal 'show'
        $box.popover 'hide'
        return false

  _lesson = ->
    $form = $('.lesson')
    $start = $('.lesson--start')
    $submit = $('.lesson--submit')
    $timer = $('.lesson--helper__timer')
    $submit.prop 'disabled', true
    $form.find('.choice').prop 'disabled', true
    $form.find('.choice').closest('label').addClass 'blurry-text'
    $start.on 'click', ->
      $(this).closest('.list-group-item').slideUp ->
        $(this).remove()
      $submit.prop 'disabled', false
      $form.find('.choice').prop 'disabled', false
      $form.find('.choice').closest('label').removeClass 'blurry-text'
      $form.find('.choice').on 'change', ->
        progress = $('.lesson--helper__progress span')
        if !$(this).hasClass('chosen')
          $(this).addClass 'chosen'
          $(this).closest('.list-group-item').find('.choice').not('.choice:checked').addClass 'chosen'
          $current = parseInt(progress.text().match(/\d+/).shift())
          progress.html $current + 1
      time = (new Date).getTime() + 60000
      $timer.countdown(time).on('update.countdown', (e) ->
        $(this).html '<i class="fa fa-clock-o"></i> ' + e.strftime('%H:%M:%S')
      ).on 'finish.countdown', ->
        $(this).parent().prop 'disabled', true
        $('.lesson--helper__completed').removeClass 'hidden'
        $form.find('.choice').not('.choice:checked').prop 'disabled', true
        $form.submit()

  _filterWordForm = ->
    $('#word-filter-form').on 'submit', (e) ->
      e.preventDefault()
      form = $(this)
      container = $('.filtered-words')
      info = $('.filter-info')
      url = form.prop('action') + '?' + form.serialize()
      $.get url, (data) ->
        container.empty()
        $(data).find('.item').each (index, element) ->
          $(element).appendTo container
        info.html $(data).find('.filter-info').html()

  {init: init})(jQuery)


$ ->
  FELS.init()
