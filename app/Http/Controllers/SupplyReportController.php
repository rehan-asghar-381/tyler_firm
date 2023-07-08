<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;
use Auth;
use App\Models\SupplyInventoryItem;
class SupplyReportController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
        $this->middleware('permission:view-supplies-report', ['only' => ['index']]);
     }

    public function index(Request $request)
    {
        $pageTitle          = "Reports";
        return view('admin.reports.supply-report',compact('pageTitle'));
    }

    public function ajaxtData(Request $request){
       
        $rData = SupplyInventoryItem::withSum('SupplyInventoryStock', 'qty')->withSum('OrderSupplyQty', 'quantity');
        // dd($rData->get());
        return DataTables::of($rData->get())
            ->addIndexColumn()
            ->editColumn('item', function ($data) {
                if ($data->item != "")
                    return $data->item;
                else
                    return '-';
            })
            ->editColumn('order_supply_qty_sum_quantity', function ($data) {
                if ($data->order_supply_qty_sum_quantity != Null)
                    return $data->order_supply_qty_sum_quantity;
                else
                    return '0';
            })
            ->editColumn('supply_inventory_stock_sum_qty', function ($data) {
                if ($data->supply_inventory_stock_sum_qty != Null)
                    return $data->supply_inventory_stock_sum_qty - $data->order_supply_qty_sum_quantity;
                else
                    return -1*$data->order_supply_qty_sum_quantity;
            })
            ->addColumn('status', function ($data) {

                $supply_inventory_stock_sum_qty = ($data->supply_inventory_stock_sum_qty !== Null) 
                                                ? $data->supply_inventory_stock_sum_qty
                                                : 0;

                $order_supply_qty_sum_quantity  = ($data->order_supply_qty_sum_quantity !== Null) 
                                                ? $data->order_supply_qty_sum_quantity
                                                : 0;

                $balance        = $supply_inventory_stock_sum_qty - $order_supply_qty_sum_quantity; 

                if($balance < 0){
                    return '<p class="text-danger">Out of Stock</p>';
                } else{
                    return '<p class="text-success">In Stock</p>';
                }                               
            })
            ->rawColumns(['status'])
            ->make(TRUE);

    }
    
}