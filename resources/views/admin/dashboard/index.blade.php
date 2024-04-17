@extends('admin.layouts.master')
@section('breadcrumb')
<ol class="breadcrumb float-sm-left">
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard', []) }}">Admin</a></li>
    <li class="breadcrumb-item active">Welcome To OMS</li>
</ol>
@endsection
@section('content')

<section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">

              <h3>{{$users}}</h3>

              <p>Total Users</p>
            </div>
            <div class="icon">
              <i class=""></i>
            </div>
            <a href="{{url('/admin/users')}}" class="small-box-footer">All Users <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
