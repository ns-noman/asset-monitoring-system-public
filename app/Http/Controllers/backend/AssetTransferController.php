<?php

namespace App\Http\Controllers\backend;

use App\Models\AssignAsset;
use App\Models\TransferRequisition;
use App\Models\RequisitionDetails;
use App\Models\Branch;
use App\Models\AssetTransfer;
use App\Models\Category;
use App\Models\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class AssetTransferController extends Controller
{    
    protected $breadcrumb;
    public function __construct(){$this->breadcrumb = ['title'=>'Asset Transfer'];}
    public function outgoing()
    {
        $data['breadcrumb'] = $this->breadcrumb;
        return view('backend.asset-transfers.outgoing', compact('data'));
    }

    public function create()
    {
        $branch_id = Auth::guard('admin')->user()->branch_id;
        $data['title'] = 'Create';
        $data['breadcrumb'] = $this->breadcrumb;
        $data['transfer_requistions'] = TransferRequisition::where('status',1)
                                        ->where('from_branch_id', $branch_id)
                                        ->select('id','tr_no')
                                        ->orderByDesc('tr_no')
                                        ->get()
                                        ->toArray();
        $data['categories'] = Category::with('subcategories')->where(['parent_cat_id'=> 0,'status'=> 1])->orderBy('title')->get()->toArray();
        $data['branches'] = Branch::where('id','!=', $branch_id)->where('status',1)->orderBy('title')->get();
        return view('backend.asset-transfers.create-or-edit-direct-transfer',compact('data'));
    }
    
    public function storeTransferFromRequisition(Request $request)
    {
        $transfer_requistion_id = $request->transfer_requistion_id;
        $tr = TransferRequisition::find($transfer_requistion_id);
        $from_branch_id = $tr->from_branch_id;
        $to_branch_id = $tr->to_branch_id;
        $created_by_id = Auth::guard('admin')->user()->id;
        $asset_ids = $request->asset_ids;
        foreach ($asset_ids as $key => $asset_id) {
            $data['asset_id'] = $asset_id;
            $data['date'] = date('Y-m-d');
            $data['status'] = 0;
            $data['from_branch_id'] = $from_branch_id;
            $data['to_branch_id'] = $to_branch_id;
            $data['created_by_id'] = $created_by_id;
            AssignAsset::where(['branch_id'=> $from_branch_id, 'asset_id'=> $asset_id, 'in_branch'=> 1])->first()
                        ->update(['in_branch'=>0,'updated_by_id'=>$created_by_id]);
            Asset::find($asset_id)->update(['location'=>2]);
            AssetTransfer::create($data);
        }
        $tr->update(['status'=>4]);
        return redirect()->route('assets-transfers.outgoing')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function storeTransferWithoutRequisition(Request $request)
    {
        $from_branch_id = Auth::guard('admin')->user()->branch_id;
        $to_branch_id = $request->branch_id;
        $created_by_id = Auth::guard('admin')->user()->id;
        $asset_id = $request->asset_id;

        $data['asset_id'] = $asset_id;
        $data['date'] = date('Y-m-d');
        $data['status'] = 0;
        $data['from_branch_id'] = $from_branch_id;
        $data['to_branch_id'] = $to_branch_id;
        $data['created_by_id'] = $created_by_id;

        AssignAsset::where(['branch_id'=> $from_branch_id, 'asset_id'=> $asset_id, 'in_branch'=> 1])->first()
                    ->update(['in_branch'=>0,'updated_by_id'=>$created_by_id]);

        Asset::find($asset_id)->update(['location'=>2]);
        AssetTransfer::create($data);
        return redirect()->route('assets-transfers.outgoing')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }
    
    public function assetsTransferOutgoingList(Request $request)
    {
        $select = [
            'asset_transfers.id',
            'asset_transfers.date',
            'asset_transfers.status',
            'assets.title as asset_title',
            'assets.code as code_title',
            'branches.title as to_branch_title',
            'admins_creator.name as created_by',
            'admins_receiver.name as received_by',
        ];
        $branch_id = Auth::guard('admin')->user()->branch_id;

        $query = AssetTransfer::join('assets','assets.id','=','asset_transfers.asset_id')
                            ->join('branches','branches.id','=','asset_transfers.to_branch_id')
                            ->leftJoin('admins as admins_creator','admins_creator.id','=','asset_transfers.created_by_id')
                            ->leftJoin('admins as admins_receiver','admins_receiver.id','=','asset_transfers.updated_by_id')
                            ->where(['asset_transfers.from_branch_id'=> $branch_id]);
        if(!$request->has('order')) $query = $query->orderBy('asset_transfers.id','desc');
        $query = $query->select($select);
        return DataTables::of($query)->make(true);
    }


    public function requisitionDetails($req_id)
    {
        $tr = TransferRequisition::find($req_id)->toArray();
        $trdSelect = 
        [
            'requisition_details.id as req_details_id',
            'requisition_details.quantity',
            'categories.id as cat_id',
            'categories.title as category_title'
        ];
        $tr['trd'] = RequisitionDetails::join('categories', 'categories.id','=', 'requisition_details.category_id')
                                    ->where('requisition_details.requisition_id', $req_id)
                                    ->select($trdSelect)
                                    ->get()
                                    ->toArray();
        $tr['branch'] = Branch::select('id', 'title')->where('id', $tr['to_branch_id'])->first()->toArray();


        foreach ($tr['trd'] as $key => &$trd)
        {
            $category_id = $trd['cat_id'];
            $branch_id = $tr['from_branch_id'];
            $trd['assets'] = AssetTransferController::getAssetList($category_id, $branch_id);
        }


        return response()->json($tr, 200);
    }


    public function getAssetListByCat($category_id)
    {
        $branch_id = Auth::guard('admin')->user()->branch_id;
        $data = AssetTransferController::getAssetList($category_id, $branch_id);
        return response()->json($data, 200);
    }
    public function getAssetList($cat_id, $branch_id)
    {
        $category_ids = $this->getRelatedCatIds($cat_id);
        
        return AssignAsset::join('assets','assets.id','=','assign_assets.asset_id')
                            ->whereIn('assets.category_id', $category_ids)
                            ->where('assign_assets.branch_id', $branch_id)
                            ->where(['assets.status'=> 1,'assign_assets.in_branch'=> 1])
                            ->select(['assets.id', 'assets.title', 'assets.code'])
                            ->get()->toArray();
    }

    public function destroy($id)
    {
        try {
            AssetTransfer::destroy($id);
            return redirect()->back()->with('alert', [
                'messageType' => 'success',
                'message' => 'Data Deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'messageType' => 'warning',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function incoming()
    {
        $data['breadcrumb'] = $this->breadcrumb;
        return view('backend.asset-transfers.incoming', compact('data'));
    }
    public function assetsTransferIncomingList(Request $request)
    {
        $select = [
            'asset_transfers.id',
            'asset_transfers.date',
            'asset_transfers.status',
            'assets.title as asset_title',
            'assets.code as code_title',
            'branches.title as to_branch_title',
            'admins_creator.name as created_by',
            'admins_receiver.name as received_by',
        ];
        $branch_id = Auth::guard('admin')->user()->branch_id;

        $query = AssetTransfer::join('assets','assets.id','=','asset_transfers.asset_id')
                            ->join('branches','branches.id','=','asset_transfers.to_branch_id')
                            ->leftJoin('admins as admins_creator','admins_creator.id','=','asset_transfers.created_by_id')
                            ->leftJoin('admins as admins_receiver','admins_receiver.id','=','asset_transfers.updated_by_id')
                            ->where(['asset_transfers.to_branch_id'=> $branch_id]);
        if(!$request->has('order')) $query = $query->orderBy('asset_transfers.id','desc');
        $query = $query->select($select);
        return DataTables::of($query)->make(true);
    }
    
    public function receive($id)
    {
        $assetTransfer = AssetTransfer::find($id);
        $from_branch_id = $assetTransfer->from_branch_id;
        $to_branch_id = $assetTransfer->to_branch_id;
        $asset_id = $assetTransfer->asset_id;
        $received_by = Auth::guard('admin')->user()->id;
        $data['branch_id'] = $to_branch_id;
        $data['asset_id'] = $asset_id;
        $data['in_branch'] = 1;
        $data['created_by_id'] = $received_by;
        AssignAsset::create($data);
        Asset::find($asset_id)->update(['location'=>1]);
        AssetTransfer::find($id)->update(['updated_by_id'=>$received_by,'status'=>1]);
        return 1;
    }


}