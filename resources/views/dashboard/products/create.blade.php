@extends('layouts.dashboard.app')

@section('title', __('site.create_product'))

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1> @lang('site.products') </h1>
            <ol class="breadcrumb">
                <li>
                    <a class="active" href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.dashboard') </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.products.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.products') </a>
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

                    <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="categories">@lang('site.categories')</label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" id="categories">

                                <option value="">@lang('site.all_categories')</option>

                                @foreach($categories as $category)

                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>

                                @endforeach
                            </select>

                            @error('category_id')
                                <span  class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        @foreach(config('translatable.locales') as $locale)

                            <div class="form-group">
                                <label for="{{$locale}}.name"> @lang('site.'. $locale .'.name') </label>
                                <input type="text" name="{{ $locale }}[name]" class="form-control @error($locale.'.name') is-invalid @enderror" value="{{ old($locale.'.name') }}" id="{{$locale}}.name">
                                @error($locale.'.name')
                                    <span  class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="{{$locale}}.description"> @lang('site.'. $locale .'.description') </label>
                                <textarea  name="{{ $locale }}[description]" class="form-control ckeditor @error($locale.'.description') is-invalid @enderror" id="{{$locale}}.description">{{ old($locale.'.description') }}</textarea>
                                @error($locale.'.description')
                                <span  class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        @endforeach

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
                            <img src="{{ asset('uploads/products_images/default.png') }}" style="width: 100px;" class="img-thumbnail image-preview" alt="">
                        </div>

                        <div class="form-group">
                            <label for="buy_price"> @lang('site.buy_price') </label>
                            <input type="number" name="buy_price" step="0.01" class="form-control @error('buy_price') is-invalid @enderror" value="{{ old('buy_price') }}" id="buy_price">
                            @error('buy_price')
                            <span  class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sale_price"> @lang('site.sale_price') </label>
                            <input type="number" name="sale_price" step="0.01" class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price') }}" id="sale_price">
                            @error('sale_price')
                            <span  class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock"> @lang('site.stock') </label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" id="stock">
                            @error('stock')
                            <span  class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
