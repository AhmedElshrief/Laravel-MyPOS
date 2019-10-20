<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Category;
use App\client;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //create
    public function create(Client $client)
    {
        $orders = $client->orders()->with('products')->paginate(5);
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.create', compact('client', 'categories', 'orders'));
    }//end of create

    //store
    public function store(Request $request, Client $client)
    {

        $this->attach_order($request, $client);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');

    }//end of store

    //edit
    public function edit(client $client, Order $order)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.orders.edit', compact('client', 'order', 'categories', 'orders'));

    }//end of edit

    //update
    public function update(Request $request, client $client, Order $order)
    {
        $this->detach_order($order);
        $this->attach_order($request, $client);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');

    }//end of update

    //attach_order
    private function attach_order($request, $client)
    {
        $request->validate([
            'products_ids' => 'required|array',
            'quantities' => 'required|array'
        ]);

        $order = $client->orders()->create([]);
        $total_price = 0;

        foreach ($request->products_ids as $index => $product_id)
        {
            $product = Product::FindOrFail($product_id);
            $total_price += $product->sale_price * $request->quantities[$index] ;
            $order->products()->attach($product_id, ['quantity' => $request->quantities[$index] ]);

            $product->update([
                'stock' => $product->stock - $request->quantities[$index]
            ]);

        }//end of foreach

        $order->update([
            'total_price' => $total_price,
        ]);

    }//end of attach order

    //detach_orderor
    private function detach_order($order)
    {

        foreach ($order->products as $product)
        {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }

        // delete old order
        $order->delete();
    }//end of detach_order

}


