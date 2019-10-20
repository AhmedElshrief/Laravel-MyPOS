@extends('layouts.dashboard.app')

@section('title', __('site.edit_category'))

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1> @lang('site.category') </h1>
            <ol class="breadcrumb">
                <li>
                    <a class="active" href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.dashboard') </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.categories.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.category') </a>
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

                    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="post">
                        @csrf
                        @method('patch')


                        @foreach(config('translatable.locales') as $locale)

                            <div class="form-group">
                                <label for="{{$locale}}.name"> @lang('site.'. $locale .'.name') </label>
                                <input type="text" name="{{ $locale }}[name]" class="form-control @error($locale.'.name') is-invalid @enderror" value="{{ $category->translate($locale)->name}}" id="{{$locale}}.name">
                                @error($locale.'.name')
                                <span  class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        @endforeach

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-edit"></i> @lang('site.edit') </button>
                        </div>

                    </form><!-- End form -->

                </div><!-- End box-body -->

            </div><!-- End of box -->

        </section>

    </div>

@endsection
