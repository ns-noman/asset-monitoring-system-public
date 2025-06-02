<?php

namespace App\Http\Controllers\backend;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Branch;
use App\Models\Asset;
use App\Models\AssignAsset;
use App\Models\AssetTransfer;
use App\Models\AssetStatus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Auth;


class DashboardController extends Controller
{
    protected $breadcrumb;

    public function __construct()
    {
        $this->breadcrumb = ['title' => 'Dashboard'];
    }

    public function index()
    {
        $select = [
                    'asset_statuses.id as asset_status_id',
                    'assets.title',
                    'assets.code',
                    'asset_statuses.remarks',
                    'asset_statuses.date',
                ];
        $data['breadcrumb'] = $this->breadcrumb;
        $userBranchID = Auth::guard('admin')->user()->branch_id;

        $data['categories'] = Category::with('subcategories')->where(['parent_cat_id'=> 0,'status'=> 1])->orderBy('title')->get()->toArray();
        $data['branches'] = Branch::where('status',1)->select('id','title','is_main_branch')->get()->toArray();
        $data['is_main_branch'] = Branch::find($userBranchID)->is_main_branch;
        $data['userBranch'] = $userBranchID;
        $data['privilleged_menu_ids'] = $userBranchID;
        $data['notworking'] = $this->getNotWorkingAssetList();
        return view('backend.index', compact('data'));
    }

    public function getNotWorkingAssetList()
    {
        $branch_id = Auth::guard('admin')->user()->branch_id;
        $is_main_branch = Branch::find($branch_id)->is_main_branch;
        if($is_main_branch) $branch_id = null;

        // Subquery to get the maximum id where `is_okay = 1` grouped by `asset_id`
        $maxStatusIds = AssetStatus::selectRaw('MAX(id) AS id, asset_id')
            ->where('is_okay', 1)
            ->groupBy('asset_id');

        // Subquery to get the minimum id for statuses where `is_okay = 0` 
        // and `id` is greater than the maximum id where `is_okay = 1`
        $minStatusIds = AssetStatus::selectRaw('MIN(asset_statuses.id) AS id')
            ->joinSub($maxStatusIds, 'asset_status_okay_ids', function ($join) {
                $join->on('asset_status_okay_ids.asset_id', '=', 'asset_statuses.asset_id')
                    ->whereColumn('asset_statuses.id', '>', 'asset_status_okay_ids.id');
            })
            ->where('asset_statuses.is_okay', 0)
            ->groupBy('asset_statuses.asset_id');

        // Subquery to get the latest status based on the minimum id
        $latestStatuses = AssetStatus::whereIn('id', $minStatusIds);
        
        if($branch_id){
            $latestStatuses = $latestStatuses->where('branch_id', $branch_id);
        }

            

        // Main query to fetch assets with their latest status
        $assets = Asset::joinSub($latestStatuses, 'asset_status_latest', function ($join) {
                $join->on('asset_status_latest.asset_id', '=', 'assets.id');
            })
            ->select(
                'assets.id',
                'assets.title',
                'assets.code',
                'assets.code as asset_code',
                'asset_status_latest.date as trouble_from_date',
                'asset_status_latest.remarks'
            )
            ->get()->toArray();

        return $assets;

    }

    public function assetList(Request $request)
    {
        $asset_condition = $request->asset_condition;
        $category_id = $request->category_id;
        $branch_id = $request->branch_id;
        $userBranchID = Auth::guard('admin')->user()->branch_id;
        $is_main_branch = Branch::find($userBranchID)->is_main_branch;
        if(!$is_main_branch) $branch_id = $userBranchID;
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
        if($asset_condition != -1){
            $query = $query->where('assets.is_okay', $asset_condition);
        }
        if(!$request->has('order')) $query = $query->orderBy('assets.title');
        $query = $query->select('assets.*', 'categories.title as category_title', 'branches.code as branch_code','branches.title as branch_title');

        return DataTables::of($query)->with($this->assetInfo($branch_id))->make(true);

    }
    public function assetInfo($branch_id = null)
    {
        $totalAsset = Asset::query();
        $good_and_running = Asset::query();
        $bad_damaged = Asset::query();

        $in_transit = AssetTransfer::join('assets','assets.id','=','asset_transfers.asset_id')
                            ->join('branches as from_branches','from_branches.id','=','asset_transfers.from_branch_id')
                            ->join('branches as to_branches','to_branches.id','=','asset_transfers.to_branch_id')
                            ->leftJoin('admins as admins_creator','admins_creator.id','=','asset_transfers.created_by_id')
                            ->where(['asset_transfers.status'=>0,'assets.status'=>1]);
        if($branch_id){

            $subquery = AssignAsset::selectRaw('asset_id, branch_id, MAX(id) as assign_asset_id')->where('in_branch', 1)->groupBy('asset_id');

            //Total Asset Join
            $totalAsset = $totalAsset->joinSub($subquery, 'assign_assets_latest', function($join){
                                            $join->on('assets.id','=', 'assign_assets_latest.asset_id')
                                            ->leftJoin('branches','branches.id', '=', 'assign_assets_latest.branch_id');
                                        });
            $totalAsset = $totalAsset->where('branches.id', $branch_id);
            //Total Asset End

            //Good & Running
            $good_and_running = $good_and_running->joinSub($subquery, 'assign_assets_latest', function($join){
                                            $join->on('assets.id','=', 'assign_assets_latest.asset_id')
                                            ->leftJoin('branches','branches.id', '=', 'assign_assets_latest.branch_id');
                                        });
            $good_and_running = $good_and_running->where('branches.id', $branch_id);
            //Good & Running End

            //bad_damaged
            $bad_damaged = $bad_damaged->joinSub($subquery, 'assign_assets_latest', function($join){
                                            $join->on('assets.id','=', 'assign_assets_latest.asset_id')
                                            ->leftJoin('branches','branches.id', '=', 'assign_assets_latest.branch_id');
                                        });
            $bad_damaged = $bad_damaged->where('branches.id', $branch_id);
            //bad_damaged End
            
            //In Transition Start
            $in_transit = $in_transit->where(function($query) use ($branch_id){
                $query->where(['asset_transfers.from_branch_id'=>$branch_id])
                ->orWhere(['asset_transfers.to_branch_id'=> $branch_id]);
            });
            //In Transition End
        }

        $totalAsset = $totalAsset->where('assets.status',1)->count();
        $good_and_running = $good_and_running->where(['assets.is_okay'=>1,'assets.status'=>1])->count();
        $bad_damaged = $bad_damaged->where(['assets.is_okay'=>0,'assets.status'=>1])->count();
        $in_transit = $in_transit->count();
        $data = [
            'total_asset' => $totalAsset,
            'good_and_running' => $good_and_running,
            'bad_damaged' => $bad_damaged,
            'in_transit' => $in_transit,
        ];
        return $data;
    }

    public function inTransitAssetList(Request $request)
    {
        $select = [
            'asset_transfers.id',
            'asset_transfers.date',
            'asset_transfers.status',
            'assets.title as asset_title',
            'assets.code as code_title',
            'from_branches.title as from_branch_title',
            'to_branches.title as to_branch_title',
            'admins_creator.name as created_by',
        ];
        $branch_id = Auth::guard('admin')->user()->branch_id;
        $is_main_branch = Branch::find($branch_id)->is_main_branch;

        $query = AssetTransfer::join('assets','assets.id','=','asset_transfers.asset_id')
                            ->join('branches as from_branches','from_branches.id','=','asset_transfers.from_branch_id')
                            ->join('branches as to_branches','to_branches.id','=','asset_transfers.to_branch_id')
                            ->leftJoin('admins as admins_creator','admins_creator.id','=','asset_transfers.created_by_id')
                            ->where('asset_transfers.status',0);
        if(!$is_main_branch) {
            $query = $query->where(function($query) use ($branch_id){
                $query->where(['asset_transfers.from_branch_id'=>$branch_id])
                      ->orWhere(['asset_transfers.to_branch_id'=> $branch_id]);
            });
        }
        if(!$request->has('order')) $query = $query->orderBy('asset_transfers.id','desc');
        $query = $query->select($select);
        return DataTables::of($query)->make(true);
    }
}
