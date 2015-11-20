$.fn.autoLoad = (options) ->
  opts = $.extend({}, $.fn.autoLoad.defaults, options)
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

$.fn.autoLoad.defaults =
  buffer: 800
  item: '.item'
  loading: '.loading'
  paginator: '.pagination'
  nextLink: '.pagination a[rel=next]'

$.fn.outerHTML = ->
  if !@length then this else @[0].outerHTML or ((el) ->
    div = document.createElement('div')
    div.appendChild el.cloneNode(true)
    contents = div.innerHTML
    div = null
    contents)(@[0])

$.fn.extend hashCode = (str) ->
  hash = 5381
  i = 0
  while i < str.length
    char = str.charCodeAt(i)
    hash = char + (hash << 5) + hash
    i++
  hash

FELS = (($) ->
  init = ->
    _lesson()
    _search()
    _follow()
    _unfollow()
    _createWord()
    _updateWord()
    _deleteWord()
    _filterWords()
    _deleteAnswer()
    _updateAnswer()

  ## Follow and Unfollow forms helper function
  _applyRelation = (form, submit, inverse, stat) ->
    promise = $.Deferred()
    $.ajax
      data: form.serialize()
      url: form.prop('action')
      type: form.find('input[name=_method]').val() or 'post'
      beforeSend: ->
        submit.prop 'disabled', true
        form.find('.uf-loading').removeClass 'hidden'
      success: ->
        promise.resolve parseInt(stat.text().match(/\d+/).shift())
        submit.prop 'disabled', false
        form.find('.uf-loading').addClass 'hidden'
        form.wrap '<div class="hidden"></div>'
        inverse.unwrap()
    promise

  ## Follow form
  _follow = ->
    $form = $('.follow-form')
    $button = $form.find('.follow-button')
    $inverse = $('.unfollow-form')
    $stat = $('#followers')
    $form.on 'submit', (e) ->
      e.preventDefault()
      promise = _applyRelation($(this), $button, $inverse, $stat)
      promise.done (res) ->
        result = if res == 0 then res + 1 + ' follower' else res + 1 + ' followers'
        $stat.html '<i class="fa fa-heart-o"></i> ' + result

  ## Unfollow form
  _unfollow = ->
    $form = $('.unfollow-form')
    $button = $form.find('.unfollow-button')
    $inverse = $('.follow-form')
    $stat = $('#followers')
    $form.on 'submit', (e) ->
      e.preventDefault()
      promise = _applyRelation($(this), $button, $inverse, $stat)
      promise.done (res) ->
        result = if res == 2 then res - 1 + ' follower' else res - 1 + ' followers'
        $stat.html '<i class="fa fa-heart-o"></i> ' + result

  ## Word creation form
  _createWord = ->
    minimumFields = 4
    maximumFields = 10
    $container = $('.word-answers')
    $form = $container.closest('form')
    $field = $container.find('.answer')
    fieldHtml = $field.outerHTML().toString()
    $field.remove()
    replaceFieldHtml = ->
      uniqueId = hashCode Math.random().toString()
      fieldHtml.replace /word\[answers]\[\d+]/g, 'word[answers][' + uniqueId + ']'
    i = 0
    while i < minimumFields
      $container.append replaceFieldHtml()
      i++
    $container.on 'click', '.answer--addition', (e) ->
      e.preventDefault()
      if minimumFields < maximumFields
        $container.append replaceFieldHtml()
        minimumFields++
    $container.on 'click', '.answer--removal', (e) ->
      e.preventDefault()
      if minimumFields > 4
        $(this).closest('.answer').remove()
        minimumFields--
    $container.on 'change', '.answer--correctness input', ->
      $boxes = $container.find('.answer--correctness input')
      $currentBox = $(this)
      $boxes.not($currentBox).prop 'checked', false
      $boxes.filter(':checked').prev().remove()
      $currentBox.closest('.form-group').addClass 'has-success'
      $boxes.not($currentBox).closest('.form-group').removeClass 'has-success'
    $form.on 'submit', (e) ->
      if $container.find('.answer--correctness input').filter(':checked').length == 0
        e.preventDefault()
        swal
          title: 'Opps!'
          text: 'You need to mark one answer as correct'
          type: 'warning'
          timer: 1500
          showConfirmButton: false

  ## Delete answer form
  _deleteAnswer = ->
    $('.word--form__delete-answer').on 'submit', (e) ->
      e.preventDefault()
      form = $(this)
      $.ajax
        data: form.serialize()
        url: form.prop('action')
        type: form.find('input[name=_method]').val() or 'post'
        success: ->
          form.closest('.list-group-item').remove()

  ## Update answer form
  _updateAnswer = ->
    $('.word--form__update-answer').on 'submit', (e) ->
      e.preventDefault()
      form = $(this)
      $.ajax
        data: form.serialize()
        url: form.prop('action')
        type: form.find('input[name=_method]').val() or 'post'
        success: ->
          form.closest('.list-group-item').find('.solution').text form.find('input[name=solution]').val()

  ## Update word form
  _updateWord = ->
    $('.word--form__update-word').on 'submit', (e) ->
      e.preventDefault()
      form = $(this)
      word = form.closest('.word')
      $.ajax
        data: form.serialize()
        url: form.prop('action')
        type: form.find('input[name=_method]').val() or 'post'
        success: ->
          word.find('.word--info__content').text form.find('input[name=content]').val()
          word.find('.word--info__level').text form.find('select').val()

  ## Delete word form
  _deleteWord = ->
    $('.word--form__delete-word').on 'submit', (e) ->
      e.preventDefault()
      form = $(this)
      $.ajax
        data: form.serialize()
        url: form.prop('action')
        type: form.find('input[name=_method]').val() or 'post'
        success: ->
          form.closest('.word').slideUp()

  ## Search box
  _search = ->
    $form = $('#admin-search--form');
    $form.on 'input', '#admin-search--form__keyword', ->
      keyword = $.trim $(this).val()
      if (!keyword or keyword.length == 0) then $(this).popover 'toggle' else $(this).popover 'hide'
    $form.on 'submit', ->
      $box = $('#admin-search--form__keyword')
      keyword = $.trim $box.val()
      if !keyword or keyword.length == 0
        $('.admin-search--modal').modal 'show'
        $box.popover 'hide'
        return false

  ## Lesson controls
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
          current = parseInt(progress.text().match(/\d+/).shift())
          progress.html current + 1
      time = (new Date).getTime() + parseInt _FELS.lessonDuration
      $timer.countdown(time).on 'update.countdown', (e) ->
        $(this).html e.strftime('%M:%S')
      $timer.on 'finish.countdown', ->
        $(this).parent().prop 'disabled', true
        $('.lesson--helper__completed').removeClass 'hidden'
        $form.find('.choice').not('.choice:checked').prop 'disabled', true
        $form.submit()

  ## Filter words form
  _filterWords = ->
    $('.word--filter__form').on 'submit', (e) ->
      e.preventDefault()
      form = $(this)
      results = $('.word--filter__results')
      alert = $('.word--filter__info')
      url = form.prop('action') + '?' + form.serialize()
      $.get url, (data) ->
        results.empty()
        $(data).find('.word--filter__word').each (idx, el) ->
          $(el).appendTo results
        alert.html $(data).find('.word--filter__info').html()

  {init: init})($)

$ ->
  $.ajaxSetup headers:
    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')

  $('#scroll-top').on 'click', (e) ->
    e.preventDefault()
    $('body, html').animate {scrollTop: 0}, 800

  $('a[data-toggle=tab]').on 'shown.bs.tab', ->
    localStorage.setItem 'lastTab', $(this).attr('href')
  if localStorage.getItem('lastTab')
    $('[href=' + localStorage.getItem('lastTab') + ']').tab 'show'

  $('[data-toggle=tooltip]').tooltip()
  $('.auto-pagination').autoLoad()
  $('.alert').not('.alert-danger').not('.form-helper').delay(2500).slideUp()

$ ->
  FELS.init()
