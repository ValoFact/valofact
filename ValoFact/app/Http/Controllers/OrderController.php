<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderFormRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        Order::orderBy('created_at', 'desc')->paginate(9);
        //return the orders listing page
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        //return the page of creating a new order.
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(OrderFormRequest $request)
    {
        $order = Order::create($request->validated());
        $order->items()->saveMany($request->validated['items']);
        //new event : order event
        //return the order show page
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
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
        $order->update($request->validated());
        $order->items()->saveMany($request->validated['items']);
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
