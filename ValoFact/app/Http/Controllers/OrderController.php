<?php

namespace App\Http\Controllers;

use App\Events\OrderCreatedEvent;
use App\Http\Requests\{OrderFormRequest, OrdersFiltersRequest};
use App\Models\{Item, ItemCategory, Order, OrderMedia, User};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        $user = FacadesRequest::user();
        $userId = $user->id;
        $validatedData = $request->validated();
        $data = $validatedData + ['user_id' => $userId];
        //order creation
        $order = Order::create($data);
        $items = [];
        $medias = [];
        //items treatment
        foreach($data['items'] as $item):
            $item = $item + ['order_id' => $order->id];
            //dd($item);
            $itemModel = Item::create($item);
            $itemCategory = ItemCategory::find($item['item_category_id']);
            $itemCategory->items()->save($itemModel);
            $items[] = $itemModel;
        endforeach;
        //medias treatment
        if(!empty($data['medias'])){
            foreach($data['medias'] as $media):
                $mediaFile = /**@var UploadedFile|null */ $media['file'];
                if($mediaFile !== null && !$mediaFile->getError()){
                    $mediaData = ['order_id' => $order->id] + ['path' => $mediaFile->store('order', 'public')];
                    $mediaModel = OrderMedia::create($mediaData);
                    $medias[] = $mediaModel;
                }
            endforeach;
        }
        //associating relations
        $order->items()->saveMany($items);
        $order->orderMedias()->saveMany($medias);
        $user->orders()->save($order);
        event(new OrderCreatedEvent($order, 'creation', $user, route('order', $order), null));
        return to_route('public.home', $order)->with('success', 'Order \'' . $order->title . '\' created successfully');
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
        $user = FacadesRequest::user();
        $data = $request->validated();
        //deleting old items records
        $order->items->each->delete();
        //deleting old medias records
        foreach($order->medias as $media){
            Storage::disk('public')->delete($media->path);
        }
        $order->medias->each->delete();
        //items treatment
        $items = [];
        foreach($data['items'] as $item):
            $item = $item + ['order_id' => $order->id];
            $itemModel = Item::create($item);
            $itemCategory = ItemCategory::find($item['item_category_id']);
            $itemCategory->items()->save($itemModel);
            $items[] = $itemModel;
        endforeach;
        //medias treatment
        $medias = [];
        if(!empty($data['medias'])){
            foreach($data['medias'] as $media):
                $mediaFile = /**@var UploadedFile|null */ $media['file'];
                if($mediaFile !== null && !$mediaFile->getError()){
                    $mediaData = ['order_id' => $order->id] + ['path' => $mediaFile->store('order', 'public')];
                    $mediaModel = OrderMedia::create($mediaData);
                    $medias[] = $mediaModel;
                }
            endforeach;
        }
        //order model update
        $order->update($data);
        //relations update;
        $order->items()->saveMany($items);
        $order->medias()->saveMany($medias);
        if(!empty($order->bids)){
            event(new OrderCreatedEvent($order, 'update', $user, route('order', $order), null));
        }
        return to_route('order', $order)->with('success', 'Order: \'' . $order->title . '\' has been updated successfully');
    }


    public function sold(Order $order): void
    {
        if(!empty($order->bids)){
            $order->status = 'sold';
            $order->save();
            $user = User::find($order->user_id);
            $bid = $order->bids()->Accepted();
            event(new OrderCreatedEvent($order, 'sold', $user, route('order', $order), $bid));
        }else{
            throw new Exception('Order can\'t be assigned as sold because there is no bids yet');
        }
    }

    public function expired(Order $order): void
    {
        if(!empty($order->bids)){
            $order->status = 'expired';
            $order->save();
            $bid = $order->bids()->Accepted();
            $user = User::find($order->user_id);
            event(new OrderCreatedEvent($order, 'expired', $user, route('order', $order), $bid));
        }else{
            $order->status = 'expired';
            $order->save();
            $user = User::find($order->user_id);
            event(new OrderCreatedEvent($order, 'expired&nobids', $user, route('order', $order), null));
        }
        
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //deleting medias records
        foreach($order->medias as $media){
            Storage::disk('public')->delete($media->path);
        }
        $order->delete();
        //return the orders listing page with a success message of deleting the order. 
    }
}
