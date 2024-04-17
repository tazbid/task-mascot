@extends('admin.layouts.master')
@section('breadcrumb')
<ol class="breadcrumb float-sm-left">
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard', []) }}">Admin</a></li>
    <li class="breadcrumb-item active">Admins</li>
</ol>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="d-inline-block">List Of Admins</h3>
        <div class="float-right">
            {{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">Test</button> --}}
            <a onclick="event.preventDefault(); document.getElementById('download-form').submit();"
                href="javascript:void(0);" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i>
                Export</a>
            <form id="download-form" action="{{ url('admin/admins/download') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table id="admin-table" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Last IP</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created At</th>
                                <th scope="col" style="width: 15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $user)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->last_login_ip}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if ($user->status == $userActive)
                                    <span class="badge badge-info">Active</span>
                                    @if ($user->isOnline())
                                    <span class="badge badge-success">Online</span>
                                    @else
                                    <span class="badge badge-secondary">Offline</span>
                                    @endif
                                    @else
                                    <span class="badge badge-warning">Deactive</span>
                                    @endif
                                </td>
                                <td>{{date_format($user->created_at, 'D, F j, Y g:i a')}}</td>
                                <td>
                                    <a class="btn btn-sm btn-info" href="{{url("admin/customer/view", $user->id)}}"><i
                                            class="fa fa-eye" data-toggle="tooltip" data-placement="top"
                                            title="View"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Last IP</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created At</th>
                                <th scope="col" style="width: 15%">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<script>
    $(document).ready(function () {
        $("#admin-table").dataTable();
    });

</script>
@endsection
