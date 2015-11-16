@extends('layouts.admin')
@section('title', 'Disabled Accounts')
@section('content')
    <div class="admin-wrapper">
        @if (blank($users))
            @include('layouts.partials._empty')
        @else
            <div class="well-w">
                <strong class="text-info">{{ plural2('ACCOUNT', 'DISABLED', counting($users)) }}</strong>
            </div>
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
                    @foreach($users->chunk(50) as $userList)
                        @foreach($userList as $user)
                            <tr class="item">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ full_time($user->deleted_at) }}</td>
                                <td>
                                    {!! Form::restore('admin.users.disabled.restore', $user) !!}
                                    {!! Form::delete('admin.users.disabled.delete', $user) !!}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @endif
        @include('layouts.partials._loader')
        {!! paginate($users) !!}
    </div>
@stop
