<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Traits\NotificationTrait;
use App\Models\OrderHistory;
class PublicController extends Controller
{
    use NotificationTrait;
    public $fixedAdultSize;
    public $allAdultSizes;

    public $fixedBabySize;
    public $allBabySizes;
    function __construct()
    {

       $this->fixedAdultSize        = [
                                        "XS",
                                        "S",
                                        "M",
                                        "L",
                                        "XL"
                                    ];
       $this->allAdultSizes        = [
                                        "2XL",
                                        "3XL",
                                        "4XL",
                                        "5XL",
                                        "6XL"
                                    ];
       $this->fixedBabySize        = [
                                        "OSFA",
                                        "New Born",
                                        "6M",
                                        "12M",
                                        "18M"
                                    ];
       $this->allBabySizes        = [
                                        "2T",
                                        "3T",
                                        "4T",
                                        "5T",
                                        "6T"
                                    ];
   }
    public function get_quote(Request $request, $id)
    {
        $pageTitle  = "Invoice";
        $order      = Order::with([
            'OrderHistory', 
            'OrderPrice', 
            'OrderImgs', 
            'OrderColorPerLocation', 
            'OrderColorPerLocation.Product', 
            'OrderProducts', 
            'OrderProducts.Product', 
            'OrderProducts.OrderProductVariant'=>function($query) use($id){
                $query->where("order_id", "=", $id);
            },
            'OrderTransfer',
            'OrderOtherCharges'
        ])->find($id);
       
        $order_images           = $order->OrderImgs;
        $extra_details          = [];
        $client_details         = [];
        $order_prices           = [];
        $invoice_details        = [];
        $color_per_locations    = [];
        foreach($order->OrderColorPerLocation as $colorPerLocation){
            $product_name       = $colorPerLocation->Product->name;
            $color_per_locations[$product_name]["location_number"][]        = $colorPerLocation->location_number;
            $color_per_locations[$product_name]["color_per_location"][]     = $colorPerLocation->color_per_location;
        }
      
        foreach($order->OrderPrice as $OrderPrice){
            $order_prices[$OrderPrice->product_size]    = $OrderPrice->final_price;
        }
        foreach($order->OrderProducts as $OrderProduct){
            foreach($OrderProduct->OrderProductVariant as $order_product_variant){
                $size_for       = $OrderProduct->Product->size_for;
                $product_n      = $OrderProduct->product_name;
                $attr1_name     = $order_product_variant->attribute1_name;
                $attr2_name     = $order_product_variant->attribute2_name;
                $invoice_details[$size_for][$product_n][$attr1_name][$attr2_name]["pieces"]  = $order_product_variant->pieces;
                if($size_for == "adult_sizes"){
                    $invoice_details[$size_for][$product_n][$attr1_name][$attr2_name]["price"]  = (in_array($attr2_name,$this->fixedAdultSize))
                                                                                        ?$order_prices["XS-XL"]
                                                                                        :$order_prices[$attr2_name];
                }
                if($size_for == "baby_sizes"){
                    
                    $invoice_details[$size_for][$product_n][$attr1_name][$attr2_name]["price"]  = (in_array($attr2_name,$this->fixedBabySize))
                                                                                        ?$order_prices["OSFA-18M"]
                                                                                        :$order_prices[$attr2_name];
                }
            }
        }
        $client_details["date"]                     = date("m/d/Y", $order->time_id);
        $client_details["company_name"]             = $order->client->company_name;
        $client_details["job_name"]                 = $order->job_name;
        $client_details["order_number"]             = $order->order_number;
        $client_details["email"]                    = $order->client->email;
        $client_details["invoice_number"]           = $order->id;
        $client_details["projected_units"]          = $order->projected_units;
        $extra_details["label_pieces"]              = $order->OrderOtherCharges->label_pieces ?? 0;
        $extra_details["label_prices"]              = $order->OrderOtherCharges->label_prices ?? 0;
        $extra_details["fold_pieces"]               = $order->OrderOtherCharges->fold_pieces ?? 0;
        $extra_details["fold_prices"]               = $order->OrderOtherCharges->fold_prices ?? 0;
        $extra_details["fold_bag_pieces"]           = $order->OrderOtherCharges->fold_bag_pieces ?? 0;
        $extra_details["fold_bag_prices"]           = $order->OrderOtherCharges->fold_bag_prices ?? 0;
        $extra_details["foil_pieces"]               = $order->OrderOtherCharges->foil_pieces ?? 0;
        $extra_details["foil_prices"]               = $order->OrderOtherCharges->foil_prices ?? 0;
        $extra_details["palletizing_pieces"]        = $order->OrderOtherCharges->palletizing_pieces ?? 0;
        $extra_details["palletizing_prices"]        = $order->OrderOtherCharges->palletizing_prices ?? 0;
        $extra_details["remove_packaging_pieces"]   = $order->OrderOtherCharges->remove_packaging_pieces ?? 0;
        $extra_details["remove_packaging_prices"]   = $order->OrderOtherCharges->remove_packaging_prices ?? 0;
        $extra_details["fold_bag_tag_pieces"]       = $order->OrderOtherCharges->fold_bag_tag_pieces ?? 0;
        $extra_details["fold_bag_tag_prices"]       = $order->OrderOtherCharges->fold_bag_tag_prices ?? 0;
        $extra_details["hang_tag_pieces"]           = $order->OrderOtherCharges->hang_tag_pieces ?? 0;
        $extra_details["hang_tag_prices"]           = $order->OrderOtherCharges->hang_tag_prices ?? 0;
        $extra_details["art_fee"]                   = $order->OrderOtherCharges->art_fee ?? 0;
        $extra_details["art_discount"]              = $order->OrderOtherCharges->art_discount ?? 0;
        $extra_details["art_time"]                  = $order->OrderOtherCharges->art_time ?? 0;
        $extra_details["tax"]                       = $order->OrderOtherCharges->tax ?? 0;
        $extra_details["transfers_pieces"]          = $order->OrderTransfer->transfers_pieces ?? 0;
        $extra_details["transfers_prices"]          = $order->OrderTransfer->transfers_prices ?? 0;
        $extra_details["ink_color_change_pieces"]   = $order->OrderTransfer->ink_color_change_pieces ?? 0;
        $extra_details["ink_color_change_prices"]   = $order->OrderTransfer->ink_color_change_prices ?? 0;
        $extra_details["shipping_pieces"]           = $order->OrderTransfer->shipping_pieces ?? 0;
        $extra_details["shipping_charges"]          = $order->OrderTransfer->shipping_charges ?? 0;
        $extra_details["order_id"]                  = $order->id;
        $fixed_adult_sizes                          = $this->fixedAdultSize;
        $fixed_baby_sizes                           = $this->fixedBabySize;
        

        $history            = OrderHistory::where(["is_approved"=>1, "order_id"=>$id])->first();
        $is_approved        = (isset($history->id) && $history->id > 0) ? 1: 0;
       
        return view('admin.orders.public-invoice',compact('pageTitle', 'invoice_details', 'client_details', 'fixed_adult_sizes', 'fixed_baby_sizes', 'extra_details', 'color_per_locations', 'order_images', 'is_approved'));
    }

    public function store(Request $request){

        $history                = new OrderHistory();
        $history->time_id       = date('U');
        $history->order_id      = $request->order_number;
        $history->email         = $request->email;
        $history->remarks       = $request->description;
        $history->is_approved   = $request->action;
        $history->save();

        return redirect()->route("order.quote", $request->order_number)->withSuccess('Thank you for your response.');

    }
}