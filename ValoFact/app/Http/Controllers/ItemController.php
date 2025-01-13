<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;

class ItemController extends Controller
{
    /**
     * Display a listing of the items.
     */
    public function index(Order $order)
    {
        $items = $order->items()->all();
        //return the items listing page
    }

    /**
     * Show the form for creating a new item.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(ItemRequest $request): void
    {
        $item = Item::create($request->validated());
    }

    /**
     * Display the specified item.
     */
    public function show(Item $item)
    {
        //return the item showing page.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified item in storage.
     */
    public function update(ItemRequest $request, Item $item)
    {
        $item->update($request->validated());
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        //return the order showing page
    }
}
