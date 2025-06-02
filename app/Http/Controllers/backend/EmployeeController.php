<?php

namespace App\Http\Controllers\backend;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Admin;
use App\Models\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $breadcrumb;
    public function __construct(){$this->breadcrumb = ['title'=>'Employees'];}
    public function index()
    {
        $data['breadcrumb'] = $this->breadcrumb;
        $data['employees'] = Employee::with(['department', 'branch', 'designation'])->orderBy('id', 'desc')->get();
        return view('backend.employees.employees.index', compact('data'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Employee::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['departments'] = Department::get();
        $data['branches'] = Branch::get();
        $data['designations'] = Designation::get();
        $data['breadcrumb'] = $this->breadcrumb;
        return view('backend.employees.employees.create-or-edit',compact('data'));
    }
    
    public function store(Request $request)
    {
        $data = $request->all();
        if(isset($data['image'])){
            $fileName = 'emp-'. time().'.'. $data['image']->getClientOriginalExtension();
            $data['image']->move(public_path('uploads/employee'), $fileName);
            $data['image'] = $fileName;
        }
        $employee = Employee::create($data);
        return redirect()->route('employees.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }
    
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $employee = Employee::find($id);
        if(isset($data['image'])){
            $fileName = 'emp-' . time().'.'. $data['image']->getClientOriginalExtension();
            $data['image']->move(public_path('uploads/employee'), $fileName);
            $data['image'] = $fileName;
            if($employee->image) unlink(public_path('uploads/employee/'.$employee->image));
        }
        $employee->update($data);
        $admin = Admin::where('employee_id', $id)->first();
        if($admin){
            $admin->update(['branch_id'=> $employee->branch_id]);
        }

        return redirect()->route('employees.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy($id)
    {
        // if(!Item::where('unit_id',$unit->id)->count())
        //     return redirect()->back()->with('alert',['messageType'=>'warning','message'=>'Data Deletion Failed!']);
        // Employee::destroy($id);
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Deleted Successfully!']);
    }
}