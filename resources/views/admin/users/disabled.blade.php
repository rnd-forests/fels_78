@extends('layouts.admin')
@section('title', 'Disabled Accounts')
@section('content')
    <div class="admin-wrapper">
        @if (blank($users))
            <div class="text-center text-warning">No disabled account available.</div>
        @else
            <div class="panel panel-default">
                <div class="panel-body">
                    <strong class="text-info">{{ plural2('ACCOUNT', 'DISABLED', counting($users)) }}</strong>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover auto-pagination">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Disabled at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users->chunk(10) as $userList)
                        @foreach($userList as $user)
                            <tr class="item">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ full_time($user->deleted_at) }}</td>
                                <td>
                                    @include('admin.users.partials._restore_form')
                                    @include('admin.users.partials._force_delete_form')
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        @include('layouts.partials._loader')
        {!! paginate($users) !!}
    </div>
@stop
