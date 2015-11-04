<div class="modal fade" id="add-category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                {!! Form::model($category = new \FELS\Entities\Category, ['route' => 'admin.categories.store']) !!}
                    @include('admin.categories.partials._main_form', ['categorySubmit' => 'Create'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
