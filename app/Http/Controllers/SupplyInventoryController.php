<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\SupplyInventory;
use App\Models\SupplyInventoryItem;
use Yajra\DataTables\DataTables;
use Validator;
use Illuminate\Support\Facades\Auth;
class SupplyInventoryController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
        $this->middleware('permission:supplies-list|supplies-create|supplies-edit|supplies-delete', ['only' => ['index','store']]);
        $this->middleware('permission:supplies-create', ['only' => ['create','store']]);
        $this->middleware('permission:supplies-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:supplies-list', ['only' => ['index']]);
     }

    public function index(Request $request)
    {
        $pageTitle          = "Inventory";
        $data               = SupplyInventory::orderBy('id','DESC');
        return view('admin.supplies.index',compact('data', 'pageTitle'));
    }

    public function ajaxtData(Request $request){

       

        $rData = SupplyInventory::select('*');
        $rData = $rData->orderBy('id', 'DESC');

        return DataTables::of($rData->get())
            ->addIndexColumn()
            ->editColumn('item', function ($data) {
                if ($data->InventoryItem->item != "")
                    return $data->InventoryItem->item;
                else
                    return '-';
            })
            ->editColumn('qty', function ($data) {
                if ($data->qty != "")
                    return $data->qty;
                else
                    return '-';
            })
            ->editColumn('created_by_name', function ($data) {
                if ($data->created_by_name != "")
                    return $data->created_by_name;
                else
                    return '-';
            })
            ->addColumn('actions', function ($data) {

                $action_list    = '<div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti-more-alt"></i>
                </a>
            
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                if(auth()->user()->can('supplies-edit')){

                    $action_list    .= '<a class="dropdown-item" href="'.route('admin.supply.edit',$data->id).'"><i class="far fa-edit"></i> Edit</a>';
                }
                $action_list    .= '</div>
                </div>';
                return  $action_list;
            })
            ->rawColumns(['actions'])
            ->make(TRUE);

    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $errors         = [];
        $pageTitle      = "Inventroy";
        return view('admin.supplies.create',compact('pageTitle', 'errors'));

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id            = Auth::user()->id;
        $user_name          = Auth::user()->name;
        $this->validate($request, [
            'item' => 'required',
            'qty' => 'required'
        ]);
        $item_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->get('item'))));

        $supply_iventorty_item                      = SupplyInventoryItem::firstOrNew(["item_slug"=>$item_slug]);

        $supply_iventorty_item->item                = $request->get('item');
        $supply_iventorty_item->item_slug           = $item_slug;
        $supply_iventorty_item->created_by_id       = $user_id;
        $supply_iventorty_item->created_by_name     = $user_name;
        $supply_iventorty_item->save();

        $supply_inventory                       = new SupplyInventory();

        $supply_inventory->item_id              = $supply_iventorty_item->id;
        $supply_inventory->item_slug            = $supply_iventorty_item->item_slug;
        $supply_inventory->qty                  = $request->get('qty');
        $supply_inventory->created_by_id        = $user_id;
        $supply_inventory->created_by_name      = $user_name;
        $supply_inventory->save();

        return redirect()->route('admin.supply.index')
                        ->with('success','Supply Item inventory added successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id             = $request->client_id;
        $client         = SupplyInventory::find($id);
        return $client;
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle          = "Inventory";
        $supply             = SupplyInventory::find($id);
        // dd($supply);
        return view('admin.supplies.edit',compact('supply', 'pageTitle'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id            = Auth::user()->id;
        $user_name          = Auth::user()->name;
        $this->validate($request, [
            'item' => 'required',
            'qty' => 'required'
        ]);
        $item_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->get('item'))));

        $supply_iventorty_item                      = SupplyInventoryItem::firstOrNew(["item_slug"=>$item_slug]);

        $supply_iventorty_item->item                = $request->get('item');
        $supply_iventorty_item->item_slug           = $item_slug;
        $supply_iventorty_item->created_by_id       = $user_id;
        $supply_iventorty_item->created_by_name     = $user_name;
        $supply_iventorty_item->save();

        $supply_inventory                       = SupplyInventory::find($id);

        $supply_inventory->item_id              = $supply_iventorty_item->id;
        $supply_inventory->item_slug            = $supply_iventorty_item->item_slug;
        $supply_inventory->qty                  = $request->get('qty');
        $supply_inventory->save();

        return redirect()->route('admin.supply.index')
                        ->with('success','Supply Item inventory updated successfully');
    }

    public function get_available_qty(Request $request){

        
        $supply_inventory_stock_sum_qty         = 0;
        $order_supply_qty_sum_quantity          = 0;
        $available_qty                          = 0;

        $item_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->get('item'))));

        $supply_iventorty_item          = SupplyInventoryItem::withSum([
                                            'SupplyInventoryStock' => function($query) use($item_slug) {
                                            $query->where(['item_slug'=> $item_slug]);
                                        }], 'qty')
                                        ->withSum(['OrderSupplyQty' => function($query) use($item_slug) {
                                            $query->where(['item_slug'=> $item_slug]);
                                        }], 'quantity')
                                        ->where(["item_slug"=>$item_slug])
                                        ->first();

        if($supply_iventorty_item){
            
            $supply_inventory_stock_sum_qty     =($supply_iventorty_item->supply_inventory_stock_sum_qty != Null)
                                                ? $supply_iventorty_item->supply_inventory_stock_sum_qty
                                                : 0; 
            $order_supply_qty_sum_quantity     =($supply_iventorty_item->order_supply_qty_sum_quantity != Null)
                                                ? $supply_iventorty_item->order_supply_qty_sum_quantity
                                                : 0; 

            $available_qty                  = $supply_inventory_stock_sum_qty - $order_supply_qty_sum_quantity;
        }

        return json_encode(["status"=>true, "available_qty"=>$available_qty]);
        
      

    }
        
}