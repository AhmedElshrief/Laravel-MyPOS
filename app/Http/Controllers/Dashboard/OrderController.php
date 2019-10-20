<?php

namespace App\Http\Controllers\Dashboard;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request, Order $order)
    {

        $orders = Order::whereHas('client', function ($q) use ($request){

            return $q->where('name', 'like', '%' . $request->search. '%');

        })->paginate(5);

        $products = $order->products;

        return view('dashboard.orders.index', compact('orders', 'products'));

    }//end of index

    // show order details
    public function show(Order $order){

        $products = $order->products;

        return view('dashboard.orders._products', compact('order', 'products'));

    }//end of show order details


    public function destroy(Order $order)
    {

        foreach ($order->products as $product)
        {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }

        $order->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');

    }//end of destroy

}
