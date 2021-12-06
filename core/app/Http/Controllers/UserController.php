<?php

namespace App\Http\Controllers;

use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\Service;
use App\Models\ApplyService;
use App\Models\ServiceCategory;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }
    public function home()
    {
        $page_title = 'Dashboard';
        $user = Auth::user();

        $latestTrx = Transaction::where('user_id', $user->id)->latest()->take('10')->get();

        $widgets['total_deposit'] = Deposit::where('user_id', $user->id)->where('status', 1)->sum('amount');
        $widgets['total_trx'] = Transaction::where('user_id', $user->id)->count();
        $widgets['count_apply_service'] = ApplyService::where('user_id', $user->id)->where('status', '!=', 0)->count();
        $widgets['count_apply_service_pending'] = ApplyService::where('user_id', $user->id)->where('status',2)->count();
        $widgets['downline'] = User::where('ref_by', $user->id)->count();

        return view($this->activeTemplate . 'user.dashboard', compact('page_title', 'user', 'latestTrx', 'widgets'));
    }

    public function profile()
    {
        $data['page_title'] = "Profile Setting";
        $data['user'] = Auth::user();
        return view($this->activeTemplate. 'user.profile-setting', $data);
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => "sometimes|required|max:80",
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => 'mimes:png,jpg,jpeg'
        ],[
            'firstname.required'=>'First Name Field is required',
            'lastname.required'=>'Last Name Field is required'
        ]);


        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
            'city' => $request->city,
        ];

        $user = Auth::user();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $user->username . '.jpg';
            $location = 'assets/images/user/profile/' . $filename;
            $in['image'] = $filename;

            $path = './assets/images/user/profile/';
            $link = $path . $user->image;
            if (file_exists($link)) {
                @unlink($link);
            }
            $size = imagePath()['profile']['user']['size'];
            $image = Image::make($image);
            $size = explode('x', strtolower($size));
            $image->resize($size[0], $size[1]);
            $image->save($location);
        }
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile Updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $data['page_title'] = "Change Password";
        return view($this->activeTemplate . 'user.password', $data);
    }

    public function submitPassword(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);

        $general = GeneralSetting::first(['secure_password']);
        if ($general->secure_password) {
            $notify = $this->strongPassCheck($request->password);
            if ($notify) {
                return back()->withNotify($notify)->withInput($request->all());
            }
        }


        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password Changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'Current password not match.'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }


    protected function strongPassCheck($password){
        $password = $password;
        $capital = '/[ABCDEFGHIJKLMNOPQRSTUVWXYZ]/';
        $capital = preg_match($capital,$password);
        $notify = null;
        if (!$capital) {
            $notify[] = ['error','Minimum 1 capital word is required'];
        }
        $number = '/[1234567890]/';
        $number = preg_match($number,$password);
        if (!$number) {
            $notify[] = ['error','Minimum 1 number is required'];
        }
        $special = '/[`!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?~\']/';
        $special = preg_match($special,$password);
        if (!$special) {
            $notify[] = ['error','Minimum 1 special character is required'];
        }
        return $notify;
    }

    /*
     * Deposit History
     */
    public function depositHistory()
    {
        $page_title = 'Deposit History';
        $empty_message = 'No history found.';
        $logs = auth()->user()->deposits()->with(['gateway'])->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('page_title', 'empty_message', 'logs'));
    }



    public function show2faForm()
    {
        $gnl = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $secret);
        $prevcode = $user->tsc;
        $prevqr = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $prevcode);
        $page_title = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('page_title', 'secret', 'qrCodeUrl', 'prevcode', 'prevqr'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);

        $ga = new GoogleAuthenticator();
        $secret = $request->key;
        $oneCode = $ga->getCode($secret);

        if ($oneCode === $request->code) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->tv = 1;
            $user->save();


            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);


            $notify[] = ['success', 'Google Authenticator Enabled Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $ga = new GoogleAuthenticator();

        $secret = $user->tsc;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {

            $user->tsc = null;
            $user->ts = 0;
            $user->tv = 1;
            $user->save();


            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);


            $notify[] = ['success', 'Two Factor Authenticator Disable Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->withNotify($notify);
        }
    }


    public function services(){
        $page_title = 'Services';
        $services = Service::where('status', 1)->whereHas('category', function($query){
            $query->where('status', 1);
        })->paginate(getPaginate());

        return view($this->activeTemplate.'user.service.services', compact('page_title', 'services'));
    }

    public function serviceApply(Request $request){

        $request->validate([
            'id'=>'required|exists:services',
            'amount'=>'required|numeric|gt:0'
        ]);

        $findService = Service::where('id', $request->id)
                              ->where('status', 1)
                              ->whereHas('category', function($query){
                                   $query->where('status', 1);
                               })->firstOrFail();

        $chargeFree = 0;
        $requiredBalnce = 0;
        $user = Auth::user();
        $charge = 0;
        $amount = $request->amount;

        if($chargeFree == $findService->fixed_charge + $findService->parcent_charge){
            $requiredBalnce = $amount;
        }else{
            $charge = $findService->fixed_charge + ($amount * $findService->percent_charge / 100);
            $requiredBalnce = $amount + $charge;
        }

        if($user->balance < $requiredBalnce){
            $notify[] = ['error', 'Sorry insufficient balance'];
            return redirect()->route('user.deposit')->withNotify($notify);
        }

        $apply = new ApplyService();
        $apply->user_id = $user->id;
        $apply->service_id = $findService->id;
        $apply->amount = $amount;
        $apply->total_charge = $charge;
        $apply->after_charge = $requiredBalnce;
        $apply->save();

        return redirect()->route('user.service.confirm', $apply->id);
    }

    public function serviceConfirm($id){

        $apply = ApplyService::where('status', 0)
                             ->where('id', $id)
                             ->where('user_id', Auth::user()->id)
                             ->firstOrFail();

        $service = Service::where('id', $apply->service_id)
                          ->where('status', 1)
                          ->whereHas('category', function($query){
                              $query->where('status', 1);
                          })->firstOrFail();

        $page_title = 'Service Confirmation';
        $user = Auth::user();

        return view($this->activeTemplate.'user.service.confirmService', compact('page_title', 'apply', 'service', 'user'));
    }

    public function serviceSubmit(Request $request){

        $user = Auth::user();
        $apply = ApplyService::where('status', 0)
                             ->where('user_id', $user->id)
                             ->where('id', $request->id)
                             ->firstOrFail();

        $findService = Service::where('id', $apply->service_id)
                              ->where('status', 1)
                              ->whereHas('category', function($query){
                                  $query->where('status', 1);
                              })->firstOrFail();


        $customValidation = [];
        $customValidation['id'] = 'required|exists:apply_services,id';
        $selectField = [];

        if($findService->select_field && $findService->category->field_name){
            $selectArray = json_decode($findService->select_field, true);
            $selectFieldName = array_keys($selectArray);
            $selectFieldName = implode(' ', $selectFieldName);
            $selectValues = $selectArray[$selectFieldName];
            $selectValues = implode(',', $selectValues);

            $selectField[$selectFieldName] = $request->$selectFieldName;

            $customValidation[$selectFieldName] = 'required|in:'.$selectValues;
        }

        foreach(json_decode($findService->user_data, true) as $key => $value) {
            $iamge = $value['type'] == 'file' ? '|image|mimes:jpeg,png,jpg|max:2048' : null;
            $customValidation[$key] = $value['validation'] .$iamge;
        }

        $request->validate(
            $customValidation
        );


        if($user->balance < $apply->after_charge){
            $notify[] = ['error', 'Sorry insufficient balance'];
            return redirect()->route('user.deposit')->withNotify($notify);
        }

        $directory = '';
        $path = imagePath()['service']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];

        foreach($collection as $k => $v) {
            foreach (json_decode($findService->user_data) as $inKey => $inVal) {
                if ($k != $inKey) {
                    continue;
                } else {
                    if ($inVal->type == 'file') {
                        if($request->hasFile($inKey)) {
                            try {
                               $reqField[$inKey] = [
                                        'field_name' => $inKey,
                                        'field_value' => $directory.'/'.uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                            } catch (\Exception $exp) {
                                $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                return back()->withNotify($notify)->withInput();
                            }
                        }
                    } else {
                        $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $inKey,
                                'field_value' => $v,
                                'type' => $inVal->type,
                            ];
                    }
                }
            }
        }

        $data['user_data'] = $reqField;

        $user->balance -= $apply->after_charge;
        $user->save();

        $apply->status = 2;
        $apply->post_balance = $user->balance;
        $apply->select_field = $selectField ? json_encode($selectField) : null;
        $apply->user_data = json_encode($reqField);
        $apply->save();

        $general = GeneralSetting::first();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = getAmount($apply->amount);
        $transaction->post_balance = getAmount($user->balance);
        $transaction->charge = getAmount($apply->total_charge);
        $transaction->trx_type = '-';
        $transaction->details = 'Requested for ' . $apply->service->category->name.' service';
        $transaction->trx =  getTrx();
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = $transaction->details.' from '.$user->username;
        $adminNotification->click_url = route('admin.applied.pending.service');
        $adminNotification->save();

        notify($user, 'SERVICE_APPLY_COMPLETE', [
            'trx' => $transaction->trx,
            'amount' => $apply->amount,
            'charge' => $apply->total_charge,
            'currency' => $general->cur_text,
            'post_balance' => $user->balance,
            'service_name' => $apply->service->category->name,
        ]);

        $notify[] = ['success', 'Service applied successfully'];
        return redirect()->route('user.history.service')->withNotify($notify);
    }

    public function serviceHistory(){
        $page_title = 'Service History';
        $histories = ApplyService::where('user_id', Auth::user()->id)->where('status', '!=', 0)->latest()->paginate(getPaginate());
        return view($this->activeTemplate.'user.service.history', compact('page_title', 'histories'));
    }

    public function serviceHistoryPending(){
        $page_title = 'Pending Service History';
        $histories = ApplyService::where('user_id', Auth::user()->id)->where('status',2)->latest()->paginate(getPaginate());
        return view($this->activeTemplate.'user.service.history', compact('page_title', 'histories'));
    }

    public function trxHistory(){
        $page_title = 'Transaction Histories';
        $histories = Transaction::where('user_id', Auth::user()->id)->latest()->paginate(getPaginate());
        return view($this->activeTemplate.'user.trxHistory', compact('page_title', 'histories'));
    }

    public function downlines(){
        $page_title = 'Downline';
        $user = Auth::user();
        $downlines = User::where('ref_by', $user->id)->latest()->paginate(getPaginate());
        return view($this->activeTemplate.'user.downlines', compact('page_title', 'downlines'));
    }





}


