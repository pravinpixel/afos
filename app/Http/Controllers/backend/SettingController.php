<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SiteConfig;
use Auth;
use Validator;

class SettingController extends Controller
{
    public function index()
    {
        $title = 'Site Settings';
        return view('backend.settings.index', compact('title'));
    }
    
    public function get_tab(Request $request) {
        $tab_type = $request->tab_type;
        $id = Auth::id();
        $user_info = User::find($id);
        $email_info = SiteConfig::where('type', 'email')->get();
        return view('backend.settings._'.$tab_type, compact('user_info', 'email_info'));
    }

    public function account_save(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile_no' => 'required',
        ]);
        $imageName = '';
        if ($validator->passes()) {
            if( $request->hasFile('image') ){
                $imageName = time().'.'.$request->image->extension();  
                $request->image->move(public_path('images'), $imageName);
                // $image = $request->file('image')->store('public/account');
            }

            $info = User::find(Auth::id());
            $info->name = $request->name;
            $info->mobile_no = $request->mobile_no;
            $info->address = $request->address;
            if( !empty($imageName)){
                $info->image = $imageName;
            }
            $info->update();
            $message = 'Updated settings.';
            $error = 0;
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
     
        return response()->json(['error'=> $error, 'message' => $message]);
    }

    public function settings_save(Request $request) {
        
        unset($_POST['_token']);
        $type = '';
        if( $request->type == 'email') {
            $type = 'email';
        } else if( $request->type == 'sms') {

            if( !isset($_POST['enable_sms'])) {
                $_POST['enable_sms'] = 'off';
            }

            $type = 'sms';
        } else if( $request->type == 'payment') {
            $type = 'payment';
            if( !isset($_POST['payemnt_live'])) {
                $_POST['payemnt_live'] = 'off';
            }
        } else  if( $request->type == 'global') {
            $type = 'global';
        }
        
        unset($_POST['type']);
        $ins = [];
        if( $_POST ) {
            foreach ($_POST as $key => $value) {
                

                $ins[] = array( 
                            'type' => $type,
                            'field_key' => $key,
                            'field_value' => $value,
                            'status' => 1
                );
            }
        }
        if( !empty($ins)) {
            foreach ($ins as $item) {
                $flight = SiteConfig::updateOrCreate(['type' => $item['type'], 'field_key' => $item['field_key']],$item);
            }
        }

        $error = 0;
        $message = 'Updated Successfully';
     
        return response()->json(['error'=> $error, 'message' => $message]);
    }

    public function change_password(Request $request) {
        $user = User::findOrFail(Auth::id());
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);
        
        if ($validator->passes()) {
            if (Hash::check($request->old_password, $user->password)) { 
                $user->fill([
                 'password' => Hash::make($request->password)
                 ])->save();
                Auth::logout();
                $message = 'Password changed, It will logout automatically.Please try login';
                $error = 0;
            } else {
                $message = 'Old Password does not match';
                $error = 1;
            }
            
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
     
        return response()->json(['error'=> $error, 'message' => $message]);
    }
}
