<div class="collapse" id="admin-search-form">
    <div class="collapse-content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="well-w">
                    <div class="modal fade" id="search-keyword-modal">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    Your searching keyword cannot be blank. Try another keyword.
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['method' => 'GET', 'route' => 'admin.search', 'id' => 'search-form']) !!}
                        <div class="form-group has-feedback">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                {!! Form::input('search', 'q', null, [
                                    'id' => 'keyword',
                                    'data-toggle' => 'popover',
                                    'data-placement' => 'bottom',
                                    'data-content' => 'Searching pattern cannot be blank.',
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter keyword here...'
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <p><i class="fa fa-filter"></i> Choose source</p>
                            <label class="radio-inline">
                                {!! Form::radio('type', 'user', true) !!} User
                            </label>
                            <label class="radio-inline">
                                {!! Form::radio('type', 'category') !!} Category
                            </label>
                            <label class="radio-inline">
                                {!! Form::radio('type', 'word') !!} Word
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Search <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
