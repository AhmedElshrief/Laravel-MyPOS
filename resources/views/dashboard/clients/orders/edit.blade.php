@extends('layouts.dashboard.app')

@section('title', __('site.edit_order'))

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1> @lang('site.add_order') </h1>
            <ol class="breadcrumb">
                <li>
                    <a class="active" href="{{ route('dashboard.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.dashboard') </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.orders.index') }}"> <i class="fa fa-dashboard"></i> @lang('site.clients') </a>
                </li>

                <li class="active">
                    @lang('site.edit_order')
                </li>
            </ol>
        </section>


        <section class="content">

            <div class="row">

                <div class="col-md-6">
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('site.categories')</h3>
                        </div><!-- end of box header -->

                        <div class="box-body">

                            @foreach ($categories as $category)

                                <div class="panel-group">

                                    <div class="panel panel-info">

                                        <div class="panel-heading" data-toggle="collapse" href="#{{ str_replace(' ', '-', $category->name)  }}">

                                            <h4 class="panel-title" >
                                                <a data-toggle="collapse" href="#{{ str_replace(' ', '-', $category->name)  }}">{{ str_replace(' ', '-', $category->name)   }}</a>
                                            </h4>

                                        </div>{{-- End of panel heading --}}


                                        <div id="{{ str_replace(' ', '-', $category->name) }}" class="panel-collapse collapse">

                                            <div class="panel-body">

                                                @if ($category->products()->count() > 0)

                                                    <table class="table table-hover">
                                                        <tr>
                                                            <th>@lang('site.name')</th>
                                                            <th>@lang('site.stock')</th>
                                                            <th>@lang('site.sale_price')</th>
                                                            <th>@lang('site.add')</th>
                                                        </tr>

                                                        @foreach ($category->products  as $product)
                                                            <tr>

                                                                <td>{{ $product->name }}</td>
                                                                <td>{{ $product->stock }}</td>
                                                                <td>{{ number_format($product->sale_price) }}</td>
                                                                <td>

                                                                    <a href=""
                                                                       id = 'product-{{ $product->id }}'
                                                                       data-name = '{{ $product->name }}'
                                                                       data-id = '{{ $product->id }}'
                                                                       data-price = '{{ $product->sale_price }}'
                                                                       class="btn {{ in_array( $product->id, $order->products->pluck('id')->toArray() ) ? 'btn-default disabled' : 'btn-success' }}  btn-sm add-product-btn" >

                                                                        <i class="fa fa-plus"></i>

                                                                    </a>

                                                                </td>

                                                            </tr>
                                                        @endforeach

                                                    </table>

                                                @else
                                                    <h3>@lang('site.no_data_found')</h3>
                                                @endif

                                            </div>



                                        </div>

                                    </div>{{-- End of panel-info --}}

                                </div>{{-- End of panel-group --}}

                            @endforeach

                        </div><!-- End box-body -->

                    </div><!-- End of box -->

                </div> <!-- End of col-md-6 -->


                <div class="col-md-6">

                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('site.orders')</h3>
                        </div><!-- end of box header -->

                        <div class="box-body">

                            <form action="{{ route('dashboard.clients.orders.update', ['order' => $order->id, 'client' => $client->id]) }}" method="post">

                                @csrf
                                @method('patch')

                                <table class="table table-hover">

                                    <thead>
                                        <tr>
                                            <th>@lang('site.product')</th>
                                            <th>@lang('site.quantity')</th>
                                            <th>@lang('site.unit_price')</th>
                                            <th>@lang('site.price')</th>
                                        </tr>
                                    </thead>

                                    <tbody class="order-list">

                                    @php
                                        $total = 0;
                                    @endphp
                                        @foreach ($order->products as $product)

                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <input type="hidden" name="products_ids[]" value="{{ $product->id }}">
                                                <td> <input type="number" data-price="{{ number_format($product->sale_price, 2) }}" name="quantities[]" min="1" value="{{ $product->pivot->quantity }}" class="form-control input-sm product-quantity"> </td>
                                                <td>{{ number_format($product->sale_price, 2) }}</td>
                                                <td class="product-price"> {{ number_format($product->sale_price * $product->pivot->quantity, 2) }} </td>
                                                <td><button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}"> <i class="fa fa-trash"></i> </button> </td>
                                            </tr>

                                            @php
                                                /** @var TYPE_NAME $product */
                                                $total += $product->sale_price * $product->pivot->quantity;
                                            @endphp

                                        @endforeach

                                    </tbody>

                                </table>

                                <h4>
                                    @lang('site.total') :
                                    <span class="total-price"> {{$total}} </span>
                                </h4>

                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary" id="add-order-form-btn"> <i class="fa fa-edit"></i> @lang('site.edit_order') </button>
                                </div>

                            </form>


                        </div><!-- End box-body -->

                    </div><!-- End of box -->


                    <div class="box box-primary">
                        @if ($client->orders->count() > 0)


                            <div class="box-header with-border">
                                <h3 class="box-title">@lang('site.previous_orders')</h3>
                                <small class="alert-info">{{ $orders->total() }}</small>
                            </div><!-- end of box header -->

                            <div class="box-body">

                                @foreach ($orders as $order)

                                    <div class="panel-group">

                                        <div class="panel panel-success">

                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" href="#{{ $order->created_at->format('d-m-Y-s') }}">{{ $order->created_at->toFormattedDateString() }}</a>
                                                </h4>
                                            </div>

                                            <div id="{{ $order->created_at->format('d-m-Y-s') }}" class="panel-collapse collapse">

                                                <div class="panel-body">

                                                    <ul class="list-group">

                                                        @foreach ($order->products as $product)
                                                            <li class="list-group-item">{{ $product->name }}</li>
                                                        @endforeach

                                                    </ul>
                                                    <div>@lang('site.total') : {{ $order->total_price }}</div>


                                                </div>{{-- end of panel-body --}}

                                            </div>{{-- end of panel-collapse --}}

                                        </div>{{-- end of panel-success --}}

                                    </div>{{-- end of panel-group --}}

                                @endforeach

                                {{ $orders->links() }}

                            </div>{{-- end of box-body --}}



                        @else
                            <div class="box-body">
                                <h3>@lang('site.no_previous_orders')</h3>
                            </div>
                        @endif
                    </div>{{-- end of box primary for history orders --}}

                </div><!-- End of col-md-6 -->

            </div><!-- End of row -->

        </section><!-- End of content -->

    </div><!-- end of content wrapper -->

@endsection
