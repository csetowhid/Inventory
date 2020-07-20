<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DateTime;
class OrderController extends Controller
{
    function TodayOrder()
    {
    	$data = date('d/m/y');
    	$order=DB::table('orders')
    	->join('customers','orders.customer_id','customers.id')
    	->where('orders.order_date',$data)
    	->select('customers.name','orders.*')
    	->orderBy('orders.id','DESC')->get();
    	return response()->json($order);
    }
    function OrderDetails($id)
    {
        $orders=DB::table('orders')
        ->join('customers','orders.customer_id','customers.id')
        ->where('orders.id',$id)
        ->select('customers.name','customers.phone','customers.address','orders.*')
        ->first();
        return response()->json($orders);
    }
    function OrderDetailsAll($id)
    {
        $details = DB::table('order_details')
        ->join('products','order_details.product_id','products.id')
        ->where('order_details.order_id',$id)
        ->select('products.product_name','products.product_code','products.image','order_details.*')
        ->get();
        return response()->json($details);
    }
    function searchorderdate(Request $request)
    {
        $date = $request->date;
        $newdate =new DateTime($date);
        $done = $newdate->format('d/m/y');
        $order = DB::table('orders')
        ->join('customers','orders.customer_id','customers.id')
        ->select('customers.name','orders.*')
        ->where('orders.order_date',$done)
        ->get();
        return response()->json($order);
    }
    function searchordermonth(Request $request)
    {
        $month = $request->month;
        return response()->json($month);
    }
}
