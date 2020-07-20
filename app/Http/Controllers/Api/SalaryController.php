<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class SalaryController extends Controller
{
    function paid(Request $request,$id)
    {
    	$validatedData = $request->validate([
        'salary_month' => 'required',
        ]);

        $month=$request->salary_month;

        $check=DB::table('salaries')->where('employee_id',$id)->where('salary_month',$month)
        ->first();
        if ($check){
        	return response()->json('Already Paid');
        }
        else{
    	$data = array();
        $data['employee_id']=$id;
        $data['amount']=$request->salary;
        $data['salary_date']=date('d/m/Y');
        $data['salary_month']=$month;
        $data['salary_year']=date('Y');
        DB::table('salaries')->insert($data);
    }
    }
    function allSalary()
    {
    	$salary=DB::table('salaries')->select('salary_month')->groupBy('salary_month')->get();
    	return response()->json($salary);
    }
    function viewSalary($id)
    {
        $month = $id;
        $view = DB::table('salaries')
        ->join('employees','salaries.employee_id','employee_id')
        ->select('employees.name','salaries.*')
        ->where('salaries.salary_month',$month)->get();
        return response()->json($view);
    }
    function editSalary($id)
    {
        $month = $id;
        $view = DB::table('salaries')
        ->join('employees','salaries.employee_id','employee_id')
        ->select('employees.name','employees.email','salaries.*')
        ->where('salaries.id',$id)->first();
        return response()->json($view);
    }
    function updateSalary(Request $request,$id)
    {
        $data = array();
        $data['employee_id']=$request->employee_id;
        $data['amount']=$request->amount;
        $data['salary_month']=$request->salary_month;
        DB::table('salaries')->where('id', $id)->update($data);
    }
    function stockupdate(Request $request,$id)
    {
        $validatedData = $request->validate([
        'product_name' => 'required',
        'product_quantity' => 'required',
        ]);
        $data = array();
        $data['product_name']=$request->product_name;
        $data['product_quantity']=$request->product_quantity;
        DB::table('products')->where('id', $id)->update($data);
    }
}
