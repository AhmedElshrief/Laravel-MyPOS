
@extends('layouts.dashboard.app')

@section('title', __('site.orders'))

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                @lang('site.categories')
                <small> {{ $orders->total() }} @lang('site.orders') </small>
            </h1>

            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.dashboard') </a>
                </li>

                <li class="active">
                    @lang('site.orders')
                </li>
            </ol>
        </section>{{-- end con content-header --}}

        <section class="content">
            <div class="row">
                <div class="col-md-8">

                    <div class="box box-primary">

                        <div class="box-header with-border" style="padding: 15px">

                            <h3 class="box-title" style="padding-bottom: 20px"> @lang('site.orders') </h3>

                            <form action="{{ route('dashboard.orders.index') }}" method="get">

                                <div class="row">

                                    <div class="col-md-8">
                                        <input type="text" name="search" class="form-control" placeholder="search">
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-search"> @lang('site.search')</i> </button>
                                    </div>

                                </div>{{-- end of row --}}

                            </form>{{-- end of form --}}

                        </div><!-- end of box header -->

                        @if ($orders->count() > 0)

                            <div class="box-body table-responsive">

                                <table class="table table-hover">

                                    <tr>
                                        <th>@lang('site.client_name')</th>
                                        <th>@lang('site.price')</th>
{{--                                        <th>@lang('site.status')</th>--}}
                                        <th>@lang('site.created_at')</th>
                                        <th>@lang('site.action')</th>

                                    </tr>

                                    @foreach ($orders as $order)

                                        <tr>
                                            <td>{{ $order->client->name  }}</td>
                                            <td>{{ number_format($order->total_price,2)  }}</td>
                                            {{--<td>

                                                <button

                                                    data-status = "@lang('site.' .$order->status)"
                                                    data-url = "{{ route('dashboard.orders.update_status') }}"
                                                    data-method="put"
                                                    data-available-status=' ["@lang('site.processing')"], "" '
                                                    class="order-status-btn btn {{ $order->status == 'processing' }}"
                                                    >

                                                    @lang('site.' .$order->status)

                                                </button>
                                            </td>--}}

                                            <td>{{ $order->created_at->toFormattedDateString() }}</td>

                                            <td>

                                                @if (auth()->user()->can('read-orders'))

                                                    <button class="btn btn-primary btn-sm order-products"

                                                            data-url = "{{ route('dashboard.orders.show', $order->id) }}"
                                                            data-method = 'get'
                                                            data-order-id= {{ $order->id }}
                                                    >
                                                        <i class="fa fa-list"></i>
                                                        @lang('site.show')

                                                    </button>
                                                @endif

                                                @if (auth()->user()->can('update-orders'))

                                                    <a href="{{ route('dashboard.clients.orders.edit', ['client' => $order->client->id, 'order' => $order->id]) }}" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> @lang('site.update')</a>
                                                @else
                                                        <a href="#" class="btn btn-warning btn-sm">@lang('site.update')</a>
                                                @endif

                                                @if (auth()->user()->can('delete-orders'))

                                                    <form action="{{ route('dashboard.orders.destroy', $order->id) }}" method="post" style="display: inline-block">
                                                        @csrf
                                                        @method('delete')

                                                        <button type="submit" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-danger btn-sm disabled"> <i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                @endif

                                            </td>


                                        </tr>
                                    @endforeach

                                </table>{{-- end of table --}}

                            </div><!-- End of box-body -->

                        @else

                            <div class="box-body">
                                <h3>@lang('site.no_records')</h3>
                            </div>

                        @endif

                    </div><!-- End of box-primary -->

                </div>{{-- end of col-md-8 --}}



                <div class="col-md-4">

                    <div class="box box-primary">

                        <div class="box-header with-border" style="padding: 15px">

                            <h3 class="box-title" style="padding-bottom: 20px"> @lang('site.products') </h3>

                            <div class="box-body table-responsive">

                                <div id="order-product-list">


                                </div>

                            </div>{{-- e    nd of box-body --}}

                        </div>{{-- end of box-header   --}}

                    </div>{{-- end of box-primary --}}

                </div>{{-- end of col-md-4 --}}


            </div>{{-- end of row --}}

        </section><!-- End of content -->

    </div><!-- End of content-wrapper -->

@endsection

