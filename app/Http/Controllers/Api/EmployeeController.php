<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use Image;
use DB;
class EmployeeController extends Controller
{
    
    public function index()
    {
        $employee=Employee::all();
        return response()->json($employee);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'name' => 'required|unique:employees|max:255',
        'email' => 'required',
        
        ]);
        if ($request->photo) {
        $request->photo;
        $position = strpos($request->photo, ';');
        $sub = substr($request->photo, 0, $position);
        $ext = explode('/', $sub)[1];
        $name=time().".".$ext;
        $img=Image::make($request->photo)->resize(240,200);
        $upload_path='backend/employee/';
        $image_url=$upload_path.$name;
        $img->save($image_url);

        $employee = new Employee;
        $employee->name=$request->name;
        $employee->email=$request->email;
        $employee->address=$request->address;
        $employee->salary=$request->salary;
        $employee->phone=$request->phone;
        $employee->joining_date=$request->joining_date;
        $employee->photo=$image_url;
        $employee->nid=$request->nid;
        $employee->save();
        }
        else{
        $employee = new Employee;
        $employee->name=$request->name;
        $employee->email=$request->email;
        $employee->address=$request->address;
        $employee->salary=$request->salary;
        $employee->joining_date=$request->joining_date;
        $employee->phone=$request->phone;
        $employee->nid=$request->nid;
        $employee->save();
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee= Employee::findorfail($id);
        return response()->json($employee);
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
        $data = array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['address']=$request->address;
        $data['salary']=$request->salary;
        $data['phone']=$request->phone;
        $data['joining_date']=$request->joining_date;
        $data['nid']=$request->nid;
        $image=$request->newphoto;

        if ($image) {
        $position = strpos($image, ';');
        $sub = substr($image, 0, $position);
        $ext = explode('/', $sub)[1];
        $name=time().".".$ext;
        $img=Image::make($image)->resize(240,200);
        $upload_path='backend/employee/';
        $image_url=$upload_path.$name;
        $success=$img->save($image_url);

        if ($success) {
            $data['photo']=$image_url;
            $img = DB::table('employees')->where('id',$id)->first();
            $image_path = $img->photo;
            $done = unlink($image_path);
            $user = DB::table('employees')->where('id',$id)->update($data);
        }
        
    }
    else{
        $oldlogo=$request->photo;
        $data['photo']=$oldlogo;
        $user = DB::table('employees')->where('id',$id)->update($data);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = DB::table('employees')->where('id',$id)->first();
        $photo=$employee->photo;
        if($photo){
            unlink($photo);
            DB::table('employees')->where('id',$id)->delete();
        }
        else{
        DB::table('employees')->where('id',$id)->delete();
        }
        
    }
}
