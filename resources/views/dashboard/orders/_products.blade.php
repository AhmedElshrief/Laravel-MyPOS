

<div id="print-area">

    <table class="table table-hover">

        <tr>
            <th>@lang('site.name')</th>
            <th>@lang('site.quantity')</th>
            <th>@lang('site.price')</th>
        </tr>

        @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ number_format( $product->pivot->quantity * $product->sale_price ) }}</td>
            </tr>

        @endforeach

    </table>

    <h3>@lang('site.total') <span>{{ number_format($order->total_price) }}</span> </h3>

</div>{{-- end of print area --}}

<button class="form-control btn btn-primary print-btn">@lang('site.print') <i class="fa fa-print"></i> </button>
