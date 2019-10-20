@extends('layouts.dashboard.app')

@section('title', __('site.create_user'))

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1> @lang('site.users') </h1>
            <ol class="breadcrumb">
                <li>
                    <a class="active" href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.dashboard') </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.users.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.users') </a>
                </li>

                <li class="active">
                     @lang('site.add')
                </li>
            </ol>
        </section>


        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title">@lang('site.add')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="first_name"> @lang('site.first_name') </label>
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" id="first_name">
                            @error('first_name')
                                <span  class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="last_name"> @lang('site.last_name') </label>
                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" id="last_name">
                            @error('last_name')
                                <span  class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email"> @lang('site.email') </label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email">
                            @error('email')
                                <span  class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image"> @lang('site.image') </label>
                            <input type="file" name="image" class="form-control image @error('image') is-invalid @enderror" id="image">
                            @error('image')
                            <span  class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">@lang('site.image')</label>
                            <img src="{{ asset('uploads/users_images/default.jpg/') }}" style="width: 100px;" class="img-thumbnail image-preview" alt="">
                        </div>

                        <div class="form-group">
                            <label for="password"> @lang('site.password') </label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
                            @error('password')
                                <span  class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation"> @lang('site.password_confirmation') </label>
                            <input  type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation">
                            @error('password_confirmation')
                                <span  class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Permissions section -->
                        <div class="form-group">

                            <label for="">@lang('site.permissions')</label>
                            <!-- Custom Tabs -->
                                <div class="nav-tabs-custom">

                                @php
                                    $models = ['users', 'categories', 'products', 'clients', 'orders'];
                                    $maps = ['create', 'read', 'update', 'delete'];
                                @endphp

                                <ul class="nav nav-tabs">
                                   @foreach ($models as $index => $model)
                                        <li class="{{ $index == 0 ? 'active' : ''  }}">
                                            <a href="#{{ $model }}" data-toggle="tab">@lang('site.'. $model)</a>
                                        </li>
                                   @endforeach
                                </ul>

                                <div class="tab-content">

                                   @foreach ($models as $index => $model)
                                        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{$model}}">

                                            @foreach ($maps as $map)
                                                <label> <input type="checkbox" name="permissions[]" value="{{ $map.'-'.$model}}"> @lang('site.'.$map) </label>
                                            @endforeach

                                        </div><!-- End of tab-pane -->
                                   @endforeach

                                </div><!-- End of tab content -->

                            </div>
                            <!-- nav-tabs-custom -->

                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i> @lang('site.add') </button>
                        </div>

                    </form><!-- End form -->

                </div><!-- End box-body -->

            </div><!-- End of box -->

        </section>

    </div>

@endsection
