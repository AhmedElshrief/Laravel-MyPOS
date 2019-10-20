@extends('layouts.dashboard.app')

@section('title', __('site.create_category'))

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1> @lang('site.client') </h1>
            <ol class="breadcrumb">
                <li>
                    <a class="active" href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.dashboard') </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.clients.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.client') </a>
                </li>

                <li class="active">
                    @lang('site.edit')
                </li>
            </ol>
        </section>


        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    <form action="{{ route('dashboard.clients.update', $client->id) }}" method="post">
                        @csrf

                        @method('patch')

                        <div class="form-group">
                            <label for="name"> @lang('site.name') </label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $client->name }}" id="name">
                            @error('name')
                            <span class="invalid-feedback" role="">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="phone"> @lang('site.phone') </label>
                            <input type="text" name="phone[]" class="form-control @error('phone.0') is-invalid @enderror" value="{{ $client->phone[0] }}" id="name">
                            @error('phone.0')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone"> @lang('site.phone') </label>
                            <input type="text" name="phone[]" class="form-control"  value="{{ $client->phone[1] ?? '' }}" id="name">
                        </div>


                        <div class="form-group">
                            <label for="address"> @lang('site.address') </label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ $client->address }}" id="name">
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-edit"></i> @lang('site.edit') </button>
                        </div>

                    </form><!-- End form -->

                </div><!-- End box-body -->

            </div><!-- End of box -->

        </section>

    </div>

@endsection
