<?php

namespace App\Http\Controllers\backend;

use App\Models\AssignAsset;
use App\Models\Asset;
use App\Models\Branch;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class AssignAssetController extends Controller
{    
    protected $breadcrumb;
    public function __construct(){$this->breadcrumb = ['title'=>'Assign Asset'];}
    public function index()
    {
        $data['breadcrumb'] = $this->breadcrumb;
        return view('backend.asset-assigns.index', compact('data'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = AssignAsset::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['breadcrumb'] = $this->breadcrumb;
        $data['categories'] = Category::with('subcategories')->where(['parent_cat_id'=> 0,'status'=> 1])->orderBy('title')->get()->toArray();
        $data['branches'] = Branch::where('status',1)->orderBy('title')->get();
        return view('backend.asset-assigns.create-or-edit',compact('data'));
    }
    
    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_by_id'] = Auth::guard('admin')->user()->id;
        $data['date'] = date('Y-m-d');
        $data['in_branch'] = 1;
        AssignAsset::create($data);
        Asset::find($data['asset_id'])->update(['is_assigned'=>1]);
        return redirect()->route('assign-assets.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }
    
    public function assignAssets(Request $request)
    {
        $select = [
            'assign_assets.date',
            'assign_assets.in_branch',
            'assets.title as asset_title',
            'assets.code as code_title',
            'branches.title as branch_title',
            'admins.name as created_by',
        ];

        $query = AssignAsset::join('assets','assets.id','=', 'assign_assets.asset_id')
                            ->join('branches','branches.id','=', 'assign_assets.branch_id')
                            ->join('admins','admins.id','=', 'assign_assets.created_by_id');
                    if(!$request->has('order')) $query = $query->orderBy('assets.id','desc');
                    $query = $query->select($select);
        return DataTables::of($query)->make(true);
    }
    public function assetList($cat_id)
    {
        $category_ids[] = $this->getRelatedCatIds($cat_id);
        $assets = Asset::whereIn('category_id', $category_ids)->where(['status'=> 1,'is_assigned'=> 0])->get();
        return response()->json($assets, 200);
    }


}