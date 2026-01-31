@extends('layouts.blank')
@section('pagecontent')

    <div class="container mt-5">
        <a href="{{ url('roles') }}" class="btn btn-primary mx-1">Roles</a>
        @if (auth()->check() && (auth()->user()->email === 'datahouset@gmail.com' || auth()->user()->email === Auth::user()->firm_id.'@gmail.com'))
        <a href="{{ url('permissions') }}" class="btn btn-info mx-1">Permissions</a>
        @endif
        <a href="{{ url('users') }}" class="btn btn-warning mx-1">Users</a>
    </div>

    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>
                            Roles
                            {{-- @can('create role') --}}
                            {{-- @if (auth()->check() && (auth()->user()->email === 'datahouset@gmail.com' || auth()->user()->email === Auth::user()->firm_id.'@gmail.com')) --}}
                            <a href="{{ url('roles/create') }}" class="btn btn-primary float-end">Add Role</a>
                            {{-- @endcan --}}
                            {{-- @endif --}}
                        </h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Role </th>
                                    <th width="40%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{$role->firm_id}}</td>
                                    <td>
 
@if (!empty($role->firm_id) && $role->firm_id !== 'DATA0001')
    <a href="{{ url('roles/'.$role->id.'/give-permissions') }}" class="btn btn-warning">
        Add / Edit Role Permission
    </a>
   
@endif

                                        @if (auth()->check() && (auth()->user()->email === 'datahouset@gmail.com' || auth()->user()->email === Auth::user()->firm_id.'@gmail.com'))


                                        @can('update role')
                                        <a href="{{ url('roles/'.$role->id.'/edit') }}" class="btn btn-success">
                                            Edit
                                        </a>
                                        @endcan


                                        @can('delete role')
                                        <a href="{{ url('roles/'.$role->id.'/delete') }}" class="btn btn-danger mx-2">
                                            Delete
                                        </a>
                                        @endcan
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection