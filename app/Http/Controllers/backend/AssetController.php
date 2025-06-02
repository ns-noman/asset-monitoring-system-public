<?php

namespace App\Http\Controllers\backend;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Branch;
use App\Models\AssignAsset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Auth;

class AssetController extends Controller
{    
    protected $breadcrumb;
    public function __construct(){$this->breadcrumb = ['title'=>'Assets'];}
    public function index()
    {
        $data['breadcrumb'] = $this->breadcrumb;
        return view('backend.assets.index', compact('data'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Asset::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['breadcrumb'] = $this->breadcrumb;
        $data['categories'] = Category::with('subcategories')->where(['parent_cat_id'=> 0,'status'=> 1])->orderBy('title')->get()->toArray();
        return view('backend.assets.create-or-edit',compact('data'));
    }
    
    public function store(Request $request)
    {
        $data = $request->all();
        $validatedData = $request->validate([
            'code' => 'required|unique:assets,code',
        ],[
            'code.requred'=> 'The asset code is required.',
            'code.unique'=> 'The asset code must be unique.',
        ]);
        $data['created_by_id'] = Auth::guard('admin')->user()->id;
        Asset::create($data);
        return redirect()->route('assets.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validatedData = $request->validate([
            'code' => 'required|unique:assets,code,'.$id,
        ]);
        $data['updated_by_id'] = Auth::guard('admin')->user()->id;
        $asset = Asset::find($id);
        $asset->update($data);
        return redirect()->route('assets.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }
    
    public function destroy($id)
    {
        try {
            $asset = Asset::findOrFail($id);
            $asset->delete();
            return redirect()->back()->with('alert', [
                'messageType' => 'success',
                'message' => 'Asset deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'messageType' => 'warning',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function assets(Request $request)
    {
        $branch_id = Auth::guard('admin')->user()->branch_id;
        $is_main_branch = Branch::find($branch_id)->is_main_branch;

        $subquery = AssignAsset::selectRaw('asset_id, branch_id, MAX(id) as assign_asset_id')->where('in_branch', 1)->groupBy('asset_id');

        $query = Asset::join('categories','categories.id','=', 'assets.category_id')
                    ->leftJoinSub($subquery, 'assign_assets_latest', function($join){
                        $join->on('assets.id','=', 'assign_assets_latest.asset_id')
                        ->leftJoin('branches','branches.id', '=', 'assign_assets_latest.branch_id');
                    });
                    // ('assign_assets','assign_assets.asset_id','=', 'assets.id');

        if (!$is_main_branch) {
            $query = $query->where('assign_assets_latest.branch_id', $branch_id);
                // ->where('assign_assets.in_branch', 1);
        }
        if(!$request->has('order')) $query = $query->orderBy('assets.id','desc');
        $query = $query->select('assets.*', 'categories.title as category_title', 'branches.code as branch_code','assign_assets_latest.branch_id');

        return DataTables::of($query)->make(true);
    }


}