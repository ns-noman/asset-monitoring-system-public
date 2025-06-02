<?php

namespace App\Http\Controllers\backend;

use App\Models\AssignAsset;
use App\Models\Asset;
use App\Models\Branch;
use App\Models\Category;
use App\Models\AssetTransfer;
use App\Models\AssetStatus;
use App\Models\AssetStatusTemp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Auth;

class AssetStatusController extends Controller
{    
    protected $breadcrumb;
    public function __construct(){$this->breadcrumb = ['title'=>'Asset Status'];}
    public function index()
    {
        $data['breadcrumb'] = $this->breadcrumb;
        $data['categories'] = Category::with('subcategories')->where(['parent_cat_id'=> 0,'status'=> 1])->orderBy('title')->get()->toArray();
        return view('backend.asset-statuses.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = 'Create';
        $data['breadcrumb'] = $this->breadcrumb;
        $data['categories'] = Category::with('subcategories')->where(['parent_cat_id'=> 0,'status'=> 1])->orderBy('title')->get()->toArray();

        $branch_id = Auth::guard('admin')->user()->branch_id;
        $created_by_id = Auth::guard('admin')->user()->id;
        $created_at = date('Y-m-d h:i:s');
        $date = date('Y-m-d');

        AssetStatusTemp::where(['created_by_id' => $created_by_id,'branch_id' => $branch_id])->delete();

        $assets = AssignAsset::join('assets', 'assets.id', '=', 'assign_assets.asset_id')
                    ->leftJoin(DB::raw('(SELECT asset_id, MAX(id) as max_status_id FROM asset_statuses GROUP BY asset_id) as latest_status'), 'latest_status.asset_id', '=', 'assign_assets.asset_id')
                    ->leftJoin('asset_statuses', 'asset_statuses.id', '=', 'latest_status.max_status_id')
                    ->where([
                        'assets.status' => 1,
                        'assign_assets.in_branch' => 1,
                        'assign_assets.branch_id' => $branch_id
                    ])
                    ->select([
                        'assets.id as asset_id',
                        'assets.is_okay',
                        'asset_statuses.remarks',
                    ])
                    ->get()
                    ->toArray();
        foreach ($assets as $key => $asset) {
            $data['asset_id'] = $asset['asset_id'];
            $data['is_okay'] = $asset['is_okay'];
            $data['branch_id'] = $branch_id;
            $data['remarks'] = $asset['remarks'];
            $data['date'] = $date;
            $data['created_by_id'] = $created_by_id;
            $data['created_at'] = $created_at;
            AssetStatusTemp::create($data);
        }

        return view('backend.asset-statuses.create',compact('data'));
    }

    public function clearAssetStatusTemp($created_by_id,$branch_id)
    {
        AssetStatusTemp::where(['created_by_id' => $created_by_id,'branch_id' => $branch_id])->delete();
    }
    
    public function store(Request $request)
    {
        $date = $request->date;

        $branch_id = Auth::guard('admin')->user()->branch_id;
        $created_by_id = Auth::guard('admin')->user()->id;
        $created_at = date('Y-m-d h:i:s');
        $data = [];
        $assetStatusTemp = AssetStatusTemp::where(['created_by_id' => $created_by_id,'branch_id' => $branch_id])->get();
        foreach ($assetStatusTemp as $key => $ast) {
            $data[$key]['asset_id'] = $ast->asset_id;
            $data[$key]['is_okay'] = $ast->is_okay;
            $data[$key]['branch_id'] = $branch_id;
            $data[$key]['remarks'] = $ast->remarks;
            $data[$key]['date'] = $date;
            $data[$key]['created_by_id'] = $created_by_id;
            $data[$key]['created_at'] = $created_at;
            Asset::find($ast->asset_id)->update(['is_okay'=>$ast->is_okay]);
        }
        AssetStatus::insert($data);
        $this->clearAssetStatusTemp($created_by_id,$branch_id);
        return redirect()->route('assets-statuses.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }
    
    
    public function assetStatusList(Request $request)
    {
        $select = [
            'asset_statuses.id',
            'asset_statuses.date',
            'asset_statuses.is_okay',
            'asset_statuses.remarks',
            'categories.title as category_title',
            'assets.title as asset_title',
            'assets.code as asset_code',
            'branches.title as to_branch_title',
            'admins_creator.name as created_by',
        ];
        $category_id = $request->category_id;
        $date = $request->date ?? date('Y-m-d');
        $branch_id = Auth::guard('admin')->user()->branch_id;
        $latestStatusQuery = AssetStatus::selectRaw('MAX(id) as latest_id')
                            ->where('branch_id', $branch_id)
                            ->where('asset_statuses.date', $date)
                            ->groupBy('asset_id');

                            $query = AssetStatus::joinSub($latestStatusQuery, 'latest_statuses', function ($join) {
                                $join->on('asset_statuses.id', '=', 'latest_statuses.latest_id');
                            })
                            ->join('assets', 'assets.id', '=', 'asset_statuses.asset_id')
                            ->join('categories', 'categories.id', '=', 'assets.category_id')
                            ->join('branches', 'branches.id', '=', 'asset_statuses.branch_id')
                            ->leftJoin('admins as admins_creator', 'admins_creator.id', '=', 'asset_statuses.created_by_id')
                            ->where('asset_statuses.branch_id', $branch_id);
        if($category_id){
            $category_ids = $this->getRelatedCatIds($category_id);
            $query = $query->whereIn('assets.category_id', $category_ids);
        }

        $query = $query->select($select);
        if (!$request->has('order')) {
            $query = $query->orderBy('asset_statuses.is_okay', 'asc')
                        ->orderBy('asset_statuses.id', 'desc');
        }
        return DataTables::of($query)->make(true);
    }
    public function assetStatusListTemp(Request $request)
    {
        $select = [
            'asset_status_temps.id',
            'asset_status_temps.asset_id',
            'asset_status_temps.date',
            'asset_status_temps.is_okay',
            'asset_status_temps.remarks',
            'categories.title as category_title',
            'assets.title as asset_title',
            'assets.code as asset_code',
            'branches.title as to_branch_title',
            'admins_creator.name as created_by',
        ];
        $category_id = $request->category_id;
        $branch_id = Auth::guard('admin')->user()->branch_id;
        $latestStatusQuery = AssetStatusTemp::selectRaw('MAX(id) as latest_id')
                            ->where('branch_id', $branch_id)
                            ->groupBy('asset_id');
                            $query = AssetStatusTemp::joinSub($latestStatusQuery, 'latest_statuses', function ($join) {
                                $join->on('asset_status_temps.id', '=', 'latest_statuses.latest_id');
                            })
                            ->join('assets', 'assets.id', '=', 'asset_status_temps.asset_id')
                            ->join('categories', 'categories.id', '=', 'assets.category_id')
                            ->join('branches', 'branches.id', '=', 'asset_status_temps.branch_id')
                            ->leftJoin('admins as admins_creator', 'admins_creator.id', '=', 'asset_status_temps.created_by_id')
                            ->where('asset_status_temps.branch_id', $branch_id);
        if($category_id){
            $category_ids = getRelatedCatIds($category_id);
            $query = $query->whereIn('assets.category_id', $category_ids);
        }
        $query = $query->select($select);
        if (!$request->has('order')) {
            $query = $query->orderBy('asset_status_temps.is_okay', 'asc')
                        ->orderBy('asset_status_temps.id', 'desc');
        }
        return DataTables::of($query)->make(true);
    }

    public function updateTemp(Request $request)
    {
        AssetStatusTemp::find($request->asset_status_temp_id)
                        ->update(['is_okay'=> $request->asset_condition, 'remarks'=>$request->remarks]);
        return response()->json(['status'=>1,'message'=>'Data Updated Successfully!'], 200);
    }

    public function getAssetByCode($asset_code)
    {
        $branch_id = Auth::guard('admin')->user()->branch_id;
        $where = [  
                    'assets.status'=> 1,
                    'assets.code'=> $asset_code,
                    'assign_assets.in_branch'=> 1,
                    'assign_assets.branch_id'=> $branch_id,
                ];
        $assets = AssignAsset::join('assets','assets.id','=','assign_assets.asset_id')
                            ->where($where)
                            ->first();
        $status = $assets ? 1 : 0;
        return response()->json(['status'=> $status,'asset'=> $assets], 200);
    }

}