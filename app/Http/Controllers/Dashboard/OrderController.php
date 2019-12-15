<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $orders =Order::whereHas('client',function($q) use($request){
            return $q->where('name','like','%'.$request->search.'%');
        })->latest()->paginate(5);
        
        return view ('dashboard.orders.index',compact('orders'));
    }
    public function products(Order $order){
        $products =$order->products;
        return view ('dashboard.orders._products',compact('order','products'));
       
    }
    public function edit(Client $client,Order $order){
        return view('dashboard.clients.orders.edit',compact('client','order','categories'));

    }
    public function destroy(Order $order){

        foreach($order->products as $product ){
            $product->update([
                'stock'=>$product->stock + $product->pivot->quantity

            ]);

        }
        $order->delete();
        session()->flash('success',__('site.deleted_succefully'));
        return redirect()->route('dashboard.orders.index');

    }
}
