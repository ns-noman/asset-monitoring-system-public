<?php

namespace App\Http\Controllers\backend;


use App\Models\Admin;
use App\Models\Category;
use App\Models\Branch;
use App\Models\Asset;
use App\Models\AssignAsset;
use App\Models\AssetTransfer;
use App\Models\AssetStatus;
use App\Models\BasicInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Auth;

class ReportController extends Controller
{
    protected $basicInfo;
    public function __construct()
    {
        $this->basicInfo = BasicInfo::select('id','title', 'address', 'phone','logo','email')->first()->toArray();
    }
    public function assetInventoryIndex(Request $request)
    { 
        $print = $request->input('print');
        if ($print=='true') {
            $category_id = $request->category_id;
            $branch_id = $request->branch_id;
            $query = $this->assetInventoryAssetListQuery($category_id, $branch_id);
            $data['assetList'] = $query->get()->toArray();
            $data['title'] = 'Asset Inventory Report';
            $data['basicInfo'] = $this->basicInfo;

            // dd($data['basicInfo']);
            return view('backend.reports.asset-inventory.print', compact('data'));
        }else {
            $select = [
                'asset_statuses.id as asset_status_id',
                'assets.title',
                'assets.code',
                'asset_statuses.remarks',
                'asset_statuses.date',
            ];
            $userBranchID = Auth::guard('admin')->user()->branch_id;
    
            $data['categories'] = Category::with('subcategories')->where(['parent_cat_id'=> 0,'status'=> 1])->orderBy('title')->get()->toArray();
            $data['branches'] = Branch::where('status',1)->select('id','title','is_main_branch')->get()->toArray();
            $data['is_main_branch'] = Branch::find($userBranchID)->is_main_branch;
            $data['userBranch'] = $userBranchID;
            $data['privilleged_menu_ids'] = $userBranchID;
            $data['breadcrumb'] = ['title' => 'Asset Inventory Report'];
            return view('backend.reports.asset-inventory.index', compact('data'));
        }
    }

    public function assetInventoryAssetListQuery($category_id, $branch_id, $orderBy = null)
    {
        $select =  [
            'assets.title',
            'assets.code',
            'assets.is_okay',
            'assets.location',
            'assets.status',
            'assets.purchase_date',
            'assets.purchase_value',
            'categories.title as category_title',
            'branches.code as branch_code',
            'branches.title as branch_title',
        ];
        $subquery = AssignAsset::selectRaw('asset_id, branch_id, MAX(id) as assign_asset_id')->where('in_branch', 1)->groupBy('asset_id');
        $query = Asset::join('categories','categories.id','=', 'assets.category_id')
                ->leftJoinSub($subquery, 'assign_assets_latest', function($join){
                    $join->on('assets.id','=', 'assign_assets_latest.asset_id')
                    ->leftJoin('branches','branches.id', '=', 'assign_assets_latest.branch_id');
                });
        if($category_id){
            $category_ids = $this->getRelatedCatIds($category_id);
            $query = $query->whereIn('assets.category_id', $category_ids);
        }
        if($branch_id){
            $query = $query->where('branches.id', $branch_id);
        }
        if(!$orderBy) $query = $query->orderBy('assets.title');
        return $query = $query->select($select);
    }

    public function assetInventoryAssetList(Request $request)
    {
        $category_id = $request->category_id;
        $branch_id = $request->branch_id;
        $orderBy = $request->has('order');
        $query = $this->assetInventoryAssetListQuery($category_id, $branch_id, $orderBy);
        return DataTables::of($query)->make(true);
    }
  


}
