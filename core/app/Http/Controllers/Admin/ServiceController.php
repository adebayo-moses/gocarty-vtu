<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\User;
use App\Models\ApplyService;

class ServiceController extends Controller
{

    public function categoryService(){
        $page_title = 'Service category';
        $categories = ServiceCategory::latest()->paginate(getPaginate());
        $empty_message = 'Data Not Found';
        return view('admin.service.category', compact('page_title', 'categories', 'empty_message'));
    }

    public function categoryServiceStore(Request $request){

        $request->validate([
            'name'=>'required|max:191|unique:service_categories',
            'field_name'=>'sometimes|max:91',
        ]);

        $field_name = $request->field_name;

        $newCategory = new ServiceCategory();
        $newCategory->name = $request->name;
        $newCategory->status = isset($request->status) == true ? 1 : 0;

        if($field_name){
            $newCategory->field_type = 'select';
            $newCategory->field_name = str_replace(' ', '_', strtolower($field_name));
        }

        $newCategory->save();

        $notify[] = ['success', 'Service category added successfully'];
        return back()->withNotify($notify);
    }

    public function categoryServiceUpdate(Request $request){
        
        $request->validate([
            'id'=>'required|exists:service_categories',
            'name'=>'required|max:191|unique:service_categories,id',
            'field_name'=>'sometimes|max:91',
        ]);

        $field_name = $request->field_name;

        $findCategory = ServiceCategory::find($request->id);
        $findCategory->name = $request->name;
        $findCategory->status = isset($request->status) == true ? 1 : 0;

        if($field_name){
            $findCategory->field_type = 'select';
            $findCategory->field_name = str_replace(' ', '_', strtolower($field_name));
        }else{
            $findCategory->field_type = null;
            $findCategory->field_name = null;
        }

        $findCategory->save();

        $notify[] = ['success', 'Service category info updated successfully'];
        return back()->withNotify($notify);
    }

    public function service(){
        $page_title = 'Services';
        $services = Service::latest()->paginate(getPaginate());
        $empty_message = 'Service Not Found';
        return view('admin.service.index', compact('page_title', 'services', 'empty_message'));
    }

    public function createServicePage(){
        $page_title = 'Create Service';
        $categories = ServiceCategory::where('status', 1)->latest()->get();
        return view('admin.service.create', compact('page_title', 'categories'));
    }

    public function serviceStore(Request $request){

        $request->validate([
            'delay'=> 'required|max:91',
            'category_id'=> 'required|exists:service_categories,id',
            'fixed_charge'=> 'required|numeric|gte:0',
            'percent_charge'=> 'required|numeric|gte:0',
            'name'=> 'required|string|max:250',
            'icon'=> 'required|string|max:250',
            'field_name.*'=> 'required',
            'type.*'=> 'required|in:text,textarea,file',
            'validation.*'=> 'required|in:required,nullable',
        ],[
            'field_name.*.required'=>'All field is required'
        ]);

        $category = ServiceCategory::where('id', $request->category_id)->where('status', 1)->firstOrFail();

        if($category->field_type){

            if(!$request->has('select')){
                $notify[] = ['error', str_replace('_', ' ', ucfirst($category->field_name)).' field is required'];
                return back()->withNotify($notify);
            }else{
                $select = array();
                $select[str_replace(' ', '_', strtolower($category->field_name))] = $request->select;
            }

        }

        $user_data = [];

        for($a = 0; $a < count($request->field_name); $a++) {
            $arr = array();
            $arr['field_name'] = strtolower(str_replace(' ', '_', $request->field_name[$a]));
            $arr['field_level'] = $request->field_name[$a];
            $arr['type'] = $request->type[$a];
            $arr['validation'] = $request->validation[$a];
            $user_data[$arr['field_name']] = $arr;
        }

        $newService = new Service();
        $newService->name = $request->name;
        $newService->icon = $request->icon;
        $newService->category_id = $request->category_id;
        $newService->delay = $request->delay;
        $newService->select_field = $request->has('select') == true ? json_encode($select) : null;
        $newService->fixed_charge = $request->fixed_charge;
        $newService->percent_charge = $request->percent_charge;
        $newService->description = $request->description;
        $newService->user_data = json_encode($user_data);
        $newService->save();

        $notify[] = ['success', 'Service added successfully'];
        return back()->withNotify($notify);
    }

    public function serviceUpdatePage($id){

        $service = Service::findOrFail($id);
        $page_title = 'Update Service';
        $categories = ServiceCategory::where('status', 1)->latest()->get();

        $array = $service->select_field == true ? (array) json_decode($service->select_field) : null;
        $type = gettype($array);
        $label = $type == 'array' ? array_keys($array) : null;
        $label = $type == 'array' ? implode(" ",$label) : null;
        $values = $type == 'array' ? $array[$label] : null;

        return view('admin.service.edit', compact('page_title', 'service', 'categories', 'array', 'type', 'label', 'values'));
    }

    public function serviceUpdate(Request $request){

         $request->validate([
            'id'=> 'required|exists:services,id',
            'delay'=> 'required|max:91',
            'category_id'=> 'required|exists:service_categories,id',
            'fixed_charge'=> 'required|numeric|gte:0',
            'percent_charge'=> 'required|numeric|gte:0',
            'name'=> 'required|string|max:250',
            'icon'=> 'required|string|max:250',
        ]);

        if($request->field_name == null || $request->type == null || $request->validation == null){
            $notify[] = ['error', 'User data fields is required'];
            return back()->withNotify($notify);
        }

        $category = ServiceCategory::where('id', $request->category_id)->where('status', 1)->firstOrFail();

        if($category->field_type){

            if(!$request->has('select')){
                $notify[] = ['error', str_replace('_', ' ', ucfirst($category->field_name)).' field is required'];
                return back()->withNotify($notify);
            }else{
                $select = array();
                $select[str_replace(' ', '_', strtolower($category->field_name))] = $request->select;
            }

        }

         $user_data = [];

        for($a = 0; $a < count($request->field_name); $a++) {
            $arr = array();
            $arr['field_name'] = strtolower(str_replace(' ', '_', $request->field_name[$a]));
            $arr['field_level'] = $request->field_name[$a];
            $arr['type'] = $request->type[$a];
            $arr['validation'] = $request->validation[$a];
            $user_data[$arr['field_name']] = $arr;
        }

        $findService = Service::find($request->id);
        $findService->name = $request->name;
        $findService->icon = $request->icon;
        $findService->category_id = $request->category_id;
        $findService->delay = $request->delay;
        $findService->select_field = $request->has('select') == true ? json_encode($select) : null;
        $findService->fixed_charge = $request->fixed_charge;
        $findService->percent_charge = $request->percent_charge;
        $findService->description = $request->description;
        $findService->user_data = json_encode($user_data);
        $findService->save();

        $notify[] = ['success', 'Service info updated successfully'];
        return back()->withNotify($notify);
    }

    public function serviceStatus(Request $request){

        $request->validate([
            'id'=>'required|exists:services,id'
        ]);

        $findService = Service::find($request->id);

        if($findService->status == 1){
            $findService->status = 0;
            $notify[] = ['success', 'Service disabled successfully'];
        }else{
            $findService->status = 1;
            $notify[] = ['success', 'Service enabled successfully'];
        }

        $findService->save();
        return back()->withNotify($notify);
    }

    public function pendingService(){
        $page_title = 'Pending Services';
        $services = ApplyService::where('status', 2)->latest()->paginate(getPaginate());
        $empty_message = 'No results found';
        return view('admin.applied.showServices', compact('page_title', 'services', 'empty_message'));
    }

    public function serviceDetails($id){
        $service = ApplyService::where('id', $id)->where('status', '!=', 0)->firstOrFail();
        $page_title = @$service->user->fullname.' requested for '.@$service->service->category->name;
        return view('admin.applied.details', compact('page_title', 'service'));
    }

    public function serviceApprove(Request $request){

        $request->validate([
            'id'=>'required|exists:apply_services,id',
            'message'=>'required|max:1000',
        ]);

       $service = ApplyService::where('id', $request->id)->where('status', 2)->firstOrFail();
       $user = User::find($service->user_id);

       $service->status = 1;
       $service->admin_feedback = $request->message;
       $service->save();

       $general = GeneralSetting::first();

        notify($user, 'SERVICE_APPROVE', [
            'amount' => $service->amount,
            'charge' => $service->total_charge,
            'currency' => $general->cur_text,
            'service_name' => $service->service->category->name,
            'admin_feedback' => $request->message,
        ]);

       $notify[] = ['success', 'Requested service approved successfully'];
       return redirect()->route('admin.applied.pending.service')->withNotify($notify);
    }

    public function serviceReject(Request $request){

        $request->validate([
            'id'=>'required|exists:apply_services,id',
            'message'=>'required|max:1000',

        ]);

        $service = ApplyService::where('id', $request->id)->where('status', 2)->firstOrFail();

        $user = User::find($service->user_id);
        $user->balance += $service->after_charge;
        $user->save();

        $service->admin_feedback = $request->message;
        $service->status = 3;
        $service->save();

        $general = GeneralSetting::first();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = getAmount($service->after_charge);
        $transaction->post_balance = getAmount($user->balance);
        $transaction->charge = 00;
        $transaction->trx_type = '+';
        $transaction->details = 'Service request has been rejected and refund money';
        $transaction->trx =  getTrx();
        $transaction->save();

        notify($user, 'SERVICE_REJECTED', [
            'trx' => $transaction->trx,
            'amount' => $service->amount,
            'charge' => $service->total_charge,
            'currency' => $general->cur_text,
            'post_balance' => $user->balance,
            'service_name' => $service->service->category->name,
            'reason' => $service->admin_feedback,
        ]);

        $notify[] = ['success', 'Requested service canceled successfully'];
        return redirect()->route('admin.applied.pending.service')->withNotify($notify);
    }

    public function serviceApproved(){
        $page_title = 'Approved Services';
        $services = ApplyService::where('status', 1)->latest()->paginate(getPaginate());
        $empty_message = 'Data Not Found';
        return view('admin.applied.showServices', compact('page_title', 'services', 'empty_message'));
    }

    public function serviceCanceled(){
        $page_title = 'Rejected Services';
        $services = ApplyService::where('status', 3)->latest()->paginate(getPaginate());
        $empty_message = 'Data Not Found';
        return view('admin.applied.showServices', compact('page_title', 'services', 'empty_message'));
    }

    public function serviceAll(){
        $page_title = 'All Services';
        $services = ApplyService::where('status', '!=', 0)->latest()->paginate(getPaginate());
        $empty_message = 'Data Not Found';
        return view('admin.applied.showServices', compact('page_title', 'services', 'empty_message'));
    }





}



