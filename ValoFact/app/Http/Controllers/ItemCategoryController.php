<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemCategoryRequest;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the item's categories.
     */
    public function index()
    {
        $itemCategories = ItemCategory::all();
        return view('order.list-item-category', ['itemCategories' => $itemCategories]);
    }

    /**
     * Show the form for creating a new item's category.
     */
    public function create()
    {
        return view('order.create-item-category');
    }

    /**
     * Store a newly created item's category in storage.
     */
    public function store(ItemCategoryRequest $request)
    {
        $itemCategory = ItemCategory::create($request->validated());
        return to_route('itemcategory.index')->with('success', 'New item\'s category has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified item's category.
     */
    public function edit(ItemCategory $itemCategory)
    {
        return view('order.edit-item-category', ['itemCategory' => $itemCategory]);
    }

    /**
     * Update the specified item's category in storage.
     */
    public function update(ItemCategoryRequest $request, ItemCategory $itemCategory)
    {
        $itemCategory->update($request->validated());
        return to_route('itemcategory.index')->with('success', 'New item\'s category has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemCategory $itemCategory)
    {
        $itemCategory->delete();
        return to_route('itemcategory.index')->with('success', 'Item\'s category has been deleted successfully');
    }

    public function fetchItemCategories()
    {
        //ItemCategory::pluck('name', 'id');
        return ItemCategory::all();
    }
}
