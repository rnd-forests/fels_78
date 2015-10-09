@extends('layouts.admin')
@section('title', 'Current Accounts')
@section('content')
    <div class="admin-wrapper">
        <div class="panel panel-default">
            <div class="panel-body">
                <strong class="text-info">{{ plural2('ACCOUNT', 'ACTIVE', counting($users)) }}</strong>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users->chunk(10) as $userList)
                    @foreach($userList as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ full_time($user->created_at) }}</td>
                            <td>@include('admin.users.partials._delete_form')</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
        {!! paginate($users) !!}
    </div>
@stop
