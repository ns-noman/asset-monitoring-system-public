<?php


namespace App\Http\Controllers\backend;

use App\Models\Designation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
     protected $breadcrumb;
    public function __construct(){$this->breadcrumb = ['title'=>'Designation'];}
    public function index()
    {
        $data['breadcrumb'] = $this->breadcrumb;
        $data['designations'] = Designation::orderBy('id', 'desc')->get();
        return view('backend.employees.designations.index', compact('data'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Designation::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['breadcrumb'] = $this->breadcrumb;
        return view('backend.employees.designations.create-or-edit',compact('data'));
    }
    
    public function store(Request $request)
    {
        $data = $request->all();
        Designation::create($data);
        return redirect()->route('designations.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        Designation::find($id)->update($data);
        return redirect()->route('designations.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy($id)
    {
        // if(!Item::where('unit_id',$unit->id)->count())
        //     return redirect()->back()->with('alert',['messageType'=>'warning','message'=>'Data Deletion Failed!']);
        Designation::destroy($id);
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Deleted Successfully!']);
    }
}
