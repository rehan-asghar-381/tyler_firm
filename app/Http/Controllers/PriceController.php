<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PriceRange;
use App\Models\DecorationPrice;
class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
        $this->middleware('permission:prices-list|prices-create|prices-edit|prices-delete', ['only' => ['index','store']]);
        $this->middleware('permission:prices-create', ['only' => ['create','store']]);
        $this->middleware('permission:prices-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:prices-list', ['only' => ['index']]);
     }

    public function index(Request $request)
    {
        $pageTitle              = "Decoration Prices";
        $price_ranges           = PriceRange::where('is_active', 'Y')->get();
        $prices_arr             = [];
        $prices                 = DecorationPrice::get();
        foreach($prices as $price){
            $prices_arr[$price->key]        = $price->value;
        }

        return view('admin.settings.prices.index',compact('price_ranges', 'pageTitle', 'prices_arr'));
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $pageTitle              = "Decoration Prices";
        $price_ranges           = PriceRange::where('is_active', 'Y')->get();
        $prices_arr             = [];
        $prices                 = DecorationPrice::get();
        foreach($prices as $price){
            $prices_arr[$price->key]        = $price->value;
        }
        return view('admin.settings.prices.edit',compact('price_ranges', 'pageTitle', 'prices_arr'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rData      = $request->all();
        unset($rData['_token']);
        foreach($rData as $key=>$value){
            $user = DecorationPrice::updateOrCreate(['key' => $key], [ 
                'key' => $key,
                'value' => $value
            ]);
        }
        return redirect()->route('admin.price.index')
                        ->with('success','Price updated successfully');
    }    
}