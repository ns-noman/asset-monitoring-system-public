<?php

namespace App\Http\Controllers\backend;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;

class SubCategoryController extends Controller
{
    protected $breadcrumb;
    public function __construct(){$this->breadcrumb = ['title'=>'Sub Category'];}
    public function index()
    {
        $data['breadcrumb'] = $this->breadcrumb;
        return view('backend.sub-categories.index', compact('data'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Category::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['breadcrumb'] = $this->breadcrumb;
        $data['categories'] = Category::where('parent_cat_id', 0)->get();
        return view('backend.sub-categories.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $category = Category::create($data);
        return redirect()->route('sub-categories.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $data = $request->all();
        $category->update($data);
        return redirect()->route('sub-categories.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }
    
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Deleted Successfully!']);
    }
    public function allSubCategories(Request $request)
    {
        $query = DB::table('categories AS subcategory')
                    ->join('categories AS parent_categories', 'subcategory.parent_cat_id', '=', 'parent_categories.id')
                    ->where('subcategory.parent_cat_id', '!=', 0)
                    ->select(['subcategory.*','parent_categories.title AS parent_title']);
        if(!$request->has('order')) $query = $query->orderBy('subcategory.id','desc');
        return DataTables::of($query)->make(true);
    }


}
