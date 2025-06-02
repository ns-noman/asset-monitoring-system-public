<?php

namespace App\Http\Controllers\backend;

use App\Models\Asset;
use App\Models\AssignAsset;
use App\Models\TransferRequisition;
use App\Models\RequisitionDetails;
use App\Models\Category;
use App\Models\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class TransferRequisitionController extends Controller
{    
    protected $breadcrumb;
    public function outgoing()
    {
        $data['breadcrumb']['title'] = 'Outgoing Requisitions';
        return view('backend.transfer-requisitions.outgoing', compact('data'));
    }
    public function createOrEdit($id=null)
    {
        if($id){
            $data['breadcrumb']['title'] = 'Requisition Edit';
            $data['title'] = 'Edit';
            $data['item'] = TransferRequisition::find($id);
            $data['item']->trdetails = TransferRequisitionController::trDetails($id, $data['item']->from_branch_id);
        }else{
            $data['breadcrumb']['title'] = 'Requisition Create';
            $data['title'] = 'Create';
        }
        $data['categories'] = Category::with('subcategories')->where(['parent_cat_id'=> 0,'status'=> 1])->orderBy('title')->get()->toArray();
        $data['branches'] = Branch::where('status',1)->orderBy('title')->get();
        return view('backend.transfer-requisitions.create-or-edit',compact('data'));
    }
    public function trDetails($tr_id, $branch_id)
    {
        $trdetails = RequisitionDetails::join('categories','categories.id','=','requisition_details.category_id')
                ->where('requisition_id', $tr_id)
                ->select('categories.id','categories.title', 'requisition_details.quantity')
                ->get();
        foreach ($trdetails as $key => &$trd) {
            $trd->stock = TransferRequisitionController::getStock($trd->id, $branch_id);
        }
        return $trdetails;
    }
    public function getStock($cat_id, $branch_id)
    {
        $category_ids[] = $this->getRelatedCatIds($cat_id);
        $totalAsset = AssignAsset::join('assets','assets.id','=','assign_assets.asset_id')
                            ->whereIn('assets.category_id', $category_ids)
                            ->where('assign_assets.branch_id', $branch_id)
                            ->where(['assets.status'=> 1,'assign_assets.in_branch'=> 1])
                            ->count();
        return $totalAsset;
    }


    public function getCatList($branch_id){
        $data['categories'] = Category::with('subcategories')
            ->where(['parent_cat_id' => 0, 'status' => 1])
            ->orderBy('title')
            ->select('id','title')
            ->get()
            ->toArray();
        foreach ($data['categories'] as $key => &$category) {
            $category_ids = $this->getRelatedCatIds($category['id']);
            $category['stock'] = AssignAsset::join('assets', 'assets.id', '=', 'assign_assets.asset_id')
                ->whereIn('assets.category_id', $category_ids)
                ->where([
                    'assets.status' => 1,
                    'assign_assets.in_branch' => 1,
                    'assign_assets.branch_id' => $branch_id
                ])
                ->count();
            if ($category['subcategories']) {
                foreach ($category['subcategories'] as $key => &$subcategory) {
                    $sub_cat_id = $subcategory['id'];
                    $subcategory['stock'] = AssignAsset::join('assets', 'assets.id', '=', 'assign_assets.asset_id')
                        ->where('assets.category_id', $sub_cat_id)
                        ->where([
                            'assets.status' => 1,
                            'assign_assets.in_branch' => 1,
                            'assign_assets.branch_id' => $branch_id
                        ])
                        ->count();
                }
            }
        }
        return response()->json($data['categories'], 200);
    }
    



    public function editIncoming($id)
    {
        $data['breadcrumb']['title'] = 'Incoming Requisition Edit';
        $data['title'] = 'Edit';
        $data['item'] = TransferRequisition::find($id);
        $data['item']->trdetails = TransferRequisitionController::trDetails($id, $data['item']->from_branch_id);
        $data['categories'] = Category::with('subcategories')->where(['parent_cat_id'=> 0,'status'=> 1])->orderBy('title')->get()->toArray();
        $data['branches'] = Branch::where('status',1)->orderBy('title')->get();
        return view('backend.transfer-requisitions.edit-incoming-requisition',compact('data'));
    }
    
    public function store(Request $request)
    {
        $data = $request->all();
        $data['by_branch_id'] = Auth::guard('admin')->user()->branch_id;
        $data['date'] = date('Y-m-d');
        $data['created_by_id'] = Auth::guard('admin')->user()->id;
        $data['tr_no'] = TransferRequisitionController::makeNum(TransferRequisition::max('tr_no')+1);
        $tr = TransferRequisition::create($data);
        $requisition_id = $tr->id;
        for ($i=0; $i < count($data['category_id']); $i++) {
            $rd =['requisition_id'=>$requisition_id,'category_id'=>$data['category_id'][$i],'quantity'=>$data['quantity'][$i],];
            RequisitionDetails::create($rd);
        }
        return redirect()->route('transfer-requisitions.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['updated_by_id'] = Auth::guard('admin')->user()->id;
        $tr = TransferRequisition::find($id);
        RequisitionDetails::where('requisition_id',$id)->delete();
        $requisition_id = $id;
        for ($i=0; $i < count($data['category_id']); $i++) {
            $rd =['requisition_id'=>$requisition_id,'category_id'=>$data['category_id'][$i],'quantity'=>$data['quantity'][$i]];
            RequisitionDetails::create($rd);
        }
        $tr->update($data);
        return redirect()->route('transfer-requisitions.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    
    public function destroy($id)
    {
        try {
            TransferRequisition::destroy($id);
            RequisitionDetails::where('requisition_id',$id)->delete();
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

    public function transferRequisitions(Request $request)
    {
        $select = 
        [
            'transfer_requisitions.id',
            'transfer_requisitions.tr_no',
            'transfer_requisitions.date',
            'transfer_requisitions.creator_branch_remarks',
            'transfer_requisitions.receiver_branch_remarks',
            'transfer_requisitions.status',
            'from_branch.title as from_branch_title',
            'to_branch.title as to_branch_title',
            'from_branch_admin.name as from_branch_updated_by_name',
        ];
        $userInfo = Auth::guard('admin')->user();
        $query = TransferRequisition::join('branches as from_branch','from_branch.id','=', 'transfer_requisitions.from_branch_id')
                                    ->join('branches as to_branch','to_branch.id','=', 'transfer_requisitions.to_branch_id')
                                    ->leftJoin('admins as from_branch_admin','from_branch_admin.id','=', 'transfer_requisitions.from_branch_updated_by_id');
        // if($userInfo->type != 1)
        // {
            $query = $query->where('transfer_requisitions.by_branch_id', $userInfo->branch_id);
        // }
        if(!$request->has('order')) $query = $query->orderBy('transfer_requisitions.id','desc');
        $query = $query->select($select);
        return DataTables::of($query)->make(true);
    }

    public function requisitionDetails($req_id)
    {
        $rd = RequisitionDetails::join('categories','categories.id','=','requisition_details.category_id')
            ->where('requisition_id', $req_id)
            ->select('categories.title', 'requisition_details.quantity')
            ->get();
        return response()->json($rd, 200);
    }

    public function incoming()
    {
        $data['breadcrumb']['title'] = 'Incoming Requisitions';
        return view('backend.transfer-requisitions.incoming', compact('data'));
    }


    public function incomingTR(Request $request)
    {
        $select = 
        [
            'transfer_requisitions.id',
            'transfer_requisitions.tr_no',
            'transfer_requisitions.date',
            'transfer_requisitions.creator_branch_remarks',
            'transfer_requisitions.receiver_branch_remarks',
            'transfer_requisitions.status',
            'by_branch.title as by_branch_title',
            'to_branch.title as to_branch_title',
            'by_branch_admin.name as created_by',
        ];
        $userInfo = Auth::guard('admin')->user();
        $query = TransferRequisition::join('branches as by_branch','by_branch.id','=', 'transfer_requisitions.by_branch_id')
                                    ->join('branches as to_branch','to_branch.id','=', 'transfer_requisitions.to_branch_id')
                                    ->leftJoin('admins as by_branch_admin','by_branch_admin.id','=', 'transfer_requisitions.created_by_id');
        // if($userInfo->type != 1)
        // {
            $query = $query->where('transfer_requisitions.to_branch_id', $userInfo->branch_id);
        // }
                                    
        if(!$request->has('order')) $query = $query->orderBy('transfer_requisitions.id','desc');
        $query = $query->select($select);
        return DataTables::of($query)->make(true);
    }
    public function updateIncoming(Request $request, $id)
    {
        $data = $request->all();
        $data['from_branch_updated_by_id'] = Auth::guard('admin')->user()->id;
        TransferRequisition::find($id)->update($data);
        return redirect()->route('transfer-requisitions.incoming-requisition')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }
    public function makeNum($srl)
    {
        switch(strlen($srl)){
            case 1:
                $zeros = '000000';
                break;
            case 2:
                $zeros = '00000';
                break;
            case 3:
                $zeros = '0000';
                break;
            case 4:
                $zeros = '000';
                break;
            case 5:
                $zeros = '00';
                break;
            case 6:
                $zeros = '0';
            default:
                $zeros = '';
            break;
        }
        return $zeros . $srl;
    }
    
    
}