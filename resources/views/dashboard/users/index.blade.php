
@extends('layouts.dashboard.app')

@section('title', __('site.users'))

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                @lang('site.users')
            </h1>

            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.dashboard') </a>
                </li>

                <li class="active">
                    @lang('site.users')
                </li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border" style="padding: 15px">
                    <h3 class="box-title" style="padding-bottom: 20px"> @lang('site.users')  <small class="panel panel-info pl-5">{{ $users->total() }}</small> </h3>

                    <!-- Form of search -->
                    <form action="{{ route('dashboard.users.index') }}" method="get">
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                               {{-- <input list="users" name="search"/>
                                <datalist id="users">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->first_name }}">
                                        <option value="{{ $user->last_name }}">
                                        <option value="{{ $user->email }}">
                                    @endforeach

                                </datalist>--}}

                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-search"></i>  @lang('site.search')</button>

                                @if (auth()->user()->can('create-users'))
                                    <a href="{{route('dashboard.users.create')}}" class="btn btn-primary"> <i class="fa fa-plus"></i>  @lang('site.add')</a>
                                @else
                                    <button class="btn btn-primary disabled">@lang('site.add')</button>
                                @endif
                            </div>

                        </div>
                    </form> <!-- End form of search -->

                </div><!-- end of box header -->

                <div class="box-body">

                    {{-- Check count of users --}}
                   @if($users->count() > 0)

                        <table class="table table-bordered">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.first_name')</th>
                                <th>@lang('site.last_name')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>user
                                        <td><img src="{{ $user->image_path }}" style="width: 100px;" class="img-thumbnail" alt=""> </td>
                                        <td>

                                            {{-- Check Perimssion eit --}}
                                            @if (auth()->user()->can('update-users'))
                                                <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @else
                                                <a href="#" class="btn btn-info btn-sm disabled"> <i class="fa fa-edit"></i> @lang('site.edit')</a>
                                            @endif

                                            {{-- Check Perimssion eit --}}
                                            @if (auth()->user()->can('delete-users'))

                                                <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="post" style="display: inline-block">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger delete btn-sm "> <i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                </form><!-- End of form -->

                                            @else
                                                <button class="btn btn-danger btn-sm disabled"> <i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table><!-- End of Table -->

                       {{ $users->appends(request()->query())->links() }}

                   @else
                       <h2>@lang('site.no_data_found')</h2>
                   @endif

                </div><!-- End of box-body -->

            </div><!-- End of box -->

        </section><!-- End of content -->

    </div>

@endsection

