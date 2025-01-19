<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderFormRequest;
use App\Http\Requests\OrdersFiltersRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(OrdersFiltersRequest $request)
    {
        //initialising the query for filtering data
        $query = Order::select('id', 'title', 'quantity', 'location', 'status', 'created_at');

        //updating the query depending on the inserted filtering data
        if($request->validated(['title'])){
            $query = $query->whereFulltext('title', 'like', '%' . $request->input('title') . '%');
        }
        if($request->validated(['item_category_id'])){
            $query = $query->whereHas('items', function ($query) use ($request) {
                                    $query->select('id', 'order_id', 'item_category_id') // Select only necessary columns from items
                                        ->where('item_category_id', $request->input('item_category_id'));
                                });
        }
        if($request->validated(['quantiy<'])){
            $query = $query->where('quantiy', '<=', $request->input('quantiy<'));
        }
        if($request->validated(['quantiy>'])){
            $query = $query->where('quantiy', '>=', $request->input('quantiy>'));
        }
        if($request->validated(['location'])){
            $query = $query->whereFulltext('location', 'like', '%' . $request->input('location') . '%');
        }
        if($request->validated(['status'])){
            $query = $query->where('status', '=', $request->input('status'));
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(9);
        //return the orders listing page
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        
        //return the page of creating a new order.
        return view('order.create');
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(OrderFormRequest $request)
    {
        $userId = FacadesRequest::user()->id;
        $data = $request->validated() + ['user_id' => $userId];
        //dd($data);
        //dd($request->validated());
        $order = Order::create($data);
        $items = [];
        foreach($data['items'] as $item):
            $orderId = ['order_id' => $order->id];
            $item = $item + $orderId;
            $itemCategoryId = $item['item_category_id'];
            //dd($item);
            $itemModel = Item::create($item);
            $itemCategory = ItemCategory::find($itemCategoryId);
            $itemCategory->items()->save($itemModel);
            $items[] = $itemModel;
        endforeach;
        //dd($items);
        $order->items()->saveMany($items);
        
        //new event: order event
        return to_route('order.create')->with('success', 'Order \'' . $order->title . '\' created successfully');
    }

    /**
     * Display the specified order.
     */
    public function order(Order $order)
    {
        //return the order showing page.
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        //return the order editing page.
    }

    /**
     * Update the specified order in storage.
     */
    public function update(OrderFormRequest $request, Order $order)
    {
        $data = $request->validated();
        $order->items->each->delete();
        $order->update($data);
        $items = [];
        foreach($data['items'] as $item):
            $orderId = ['order_id' => $order->id];
            $item = $item + $orderId;
            $itemCategoryId = $item['item_category_id'];
            //dd($item);
            $itemModel = Item::create($item);
            $itemCategory = ItemCategory::find($itemCategoryId);
            $itemCategory->items()->save($itemModel);
            $items[] = $itemModel;
        endforeach;
        //dd($items);
        $order->items()->saveMany($items);
        //return the order showing page with a success message.
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        //return the orders listing page with a success message of deleting the order. 
    }
}
