<?php

namespace App\Http\Controllers\backend;

use App\Models\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class BranchController extends Controller
{    
    protected $breadcrumb;
    public function __construct(){$this->breadcrumb = ['title'=>'Branches'];}
    public function index()
    {
        $data['breadcrumb'] = $this->breadcrumb;
        return view('backend.branches.index', compact('data'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Branch::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['breadcrumb'] = $this->breadcrumb;
        return view('backend.branches.create-or-edit',compact('data'));
    }
    
    public function store(Request $request)
    {
        $data = $request->all();
        $branch = Branch::create($data);
        return redirect()->route('branches.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $branch = Branch::find($id);
        $branch->update($data);
        return redirect()->route('branches.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }
    
    public function destroy($id)
    {
        try {
            $branch = Branch::findOrFail($id);
            $branch->delete();
            return redirect()->back()->with('alert', [
                'messageType' => 'success',
                'message' => 'Category deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'messageType' => 'warning',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function allBranches(Request $request)
    {
        $query = Branch::query();
                    if(!$request->has('order')) $query = $query->orderBy('id','desc');
        return DataTables::of($query)->make(true);
    }


}
