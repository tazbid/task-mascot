@extends('admin.layouts.master')
@section('breadcrumb')
<ol class="breadcrumb float-sm-left">
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard', []) }}">Admin</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0)">Access-Control</a></li>
    <li class="breadcrumb-item active">Roles</li>
</ol>
@endsection
@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-key"></i>
            Roles Are Being Explained Here
        </h3>
    </div>
    <div class="card-body">
        <h4>Roles</h4>
        <div class="row">
            <div class="col-5 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                    aria-orientation="vertical">
                    <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home"
                        role="tab" aria-controls="vert-tabs-home" aria-selected="true">Super-Admin</a>
                    <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile"
                        role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Admin</a>
                    <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages"
                        role="tab" aria-controls="vert-tabs-messages" aria-selected="false">User</a>
                </div>
            </div>
            <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-tabContent">
                    <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel"
                        aria-labelledby="vert-tabs-home-tab">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin malesuada lacus ullamcorper dui
                        molestie, sit amet congue quam finibus. Etiam ultricies nunc non magna feugiat commodo. Etiam
                        odio magna, mollis auctor felis vitae, ullamcorper ornare ligula. Proin pellentesque tincidunt
                        nisi, vitae ullamcorper felis aliquam id. Pellentesque habitant morbi tristique senectus et
                        netus et malesuada fames ac turpis egestas. Proin id orci eu lectus blandit suscipit. Phasellus
                        porta, ante et varius ornare, sem enim sollicitudin eros, at commodo leo est vitae lacus. Etiam
                        ut porta sem. Proin porttitor porta nisl, id tempor risus rhoncus quis. In in quam a nibh cursus
                        pulvinar non consequat neque. Mauris lacus elit, condimentum ac condimentum at, semper vitae
                        lectus. Cras lacinia erat eget sapien porta consectetur.
                    </div>
                    <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel"
                        aria-labelledby="vert-tabs-profile-tab">
                        Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut
                        ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                        Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus
                        ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc
                        euismod pellentesque diam.
                    </div>
                    <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel"
                        aria-labelledby="vert-tabs-messages-tab">
                        Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue
                        id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac
                        tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit
                        condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus
                        tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet
                        sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum
                        gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend
                        ac ornare magna.
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.card -->
</div>
@endsection
