<?php

namespace App\Http\Controllers;

use App\Events\BidEvent;
use App\Http\Requests\BidRequest;
use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Request as FacadesRequest;

class BidController extends Controller
{
    /**
     * Display a listing of the bids.
     */
    public function index()
    {
       /* $user = FacadesRequest::user();
        $order = Order::find(33);
        $bid = Bid::create([
            'amount' => 125,
            'bid_time' => now(), 
            'order_id' => $order->id, 
            'user_id' => $user->id, 
            'status' => 'accepted'
        ]);
        $order->bids()->save($bid);
        $user->bids()->save($bid);
        return to_route('public.home');
        */
    }


    /**
     * Store a newly created bid in storage.
     */
    public function store(BidRequest $request, Order $order)
    {
        $accepted = true;
        $user = FacadesRequest::user();
        $userId = $user->id;
        $data = $request->validated();
        $dataAdd = ['bid_time' => now(), 'order_id' => $order->id, 'user_id' => $userId, 'status' => 'accepted'];
        $data = $data + $dataAdd;
        if(!empty($order->bids)){
            foreach($order->bids as $bid){
                if($data['amount'] <= $bid->amount){
                    $accepted = false;
                }
            }
        }
        
        
        if($accepted){
            if(!empty($order->bids)){
                foreach($order->bids as $bid){
                    $this->outbid($bid);
                }
            }
          
            $bid = Bid::create($data);
            $order->bids()->save($bid);
            $user->bids()->save($bid);
            
            //new event: created bid event
            //event(new BidEvent($order, 'created', null, null, route('order', $order)));

            //return the order show page with a success message
        }
        
        
        //return the order show page with a fail message
    }


    /**
     * Accept and validate the specific bid
     */
    private function outbid(Bid $bid)
    {
        $bid->status = 'outbid';
        $bid->save();
        //new event: bid outbid event
        event(new BidEvent($bid->order, 'outbid', $bid, null, route('order', $bid->order)));
        
    }



    /**
     * Remove the specified bid from storage.
     */
    public function destroy(Bid $bid)
    {
        $bid->delete();
        //return the order show page
    }
}
