<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

function setting($type,$field_key) {
    $info = \DB::table('site_config')->where('type', $type)->where('field_key', $field_key)->first();
    return $info->field_value ?? '';
}

function order_no() {
    $order_no = env('INV_PREFIX').'/'.env('START_YEAR').'-'.env('END_YEAR');
    $ord_no = '0000';
    $order_no = $order_no.'/'.$ord_no;   
     
    $info = \DB::table('orders')->orderBy('id', 'desc')->first();
    if( isset( $info ) && !empty( $info ) ) {
        
        $old_no = $info->order_no;
        $old_no = explode("/", $old_no );
        
        $old_no = end($old_no);
        $remove_old = explode("-", $old_no );
        $end = end($remove_old);
        
        $old_no = $end + 1;
        
        if( ( 4 - strlen($old_no) ) > 0 ){
            $new_no = '';
            for ($i=0; $i < (4 - strlen($old_no) ); $i++) { 
                $new_no .= '0';
            }
            $ord = $new_no.$old_no;
            
            $order_no = env('INV_PREFIX').'/'.env('START_YEAR').'-'.$ord;
        }
    } 
    return $order_no;

}

function check_access($permission_module = '') {
    $id = auth()->id();
    $module = request()->route()->getName(); 
    
    $info = User::find(auth()->id());
    $data = $info->role->permissions;
    $data = unserialize($data);
    
    $module = explode(".", $module);
    $module = current($module);
    
    if( !empty($data)) {
        if( isset( $data[$module]) && !empty($module)) {
            
            if( !empty( $permission_module ) ) {
                if( isset( $data[$module][$module.'_'.$permission_module] ) && $data[$module][$module.'_'.$permission_module] == 'on') {
                    return true;
                } else {
                    abort(403);
                }
            }
            if( isset( $data[$module])) {
                if(array_search('on', $data[$module]) ) {
                    return true;
                }
            }
            abort(403);
        }
    }
    abort(403);
}

function check_user_access($module = '', $permission_module = '') {
    $id = auth()->id();

    if( auth()->user()->is_super_admin ) {
        return true;
    } else {
        $info = User::find(auth()->id());
        $data = $info->role->permissions;
        $data = unserialize($data);
        
        if( !empty($data)) {
            if( isset( $data[$module]) && !empty($module)) {
                if( !empty( $permission_module ) ) {
                    if( isset( $data[$module][$module.'_'.$permission_module] ) && $data[$module][$module.'_'.$permission_module] == 'on') {
                        return true;
                    } 
                }
                if( !empty( $module ) && empty( $permission_module)) {
                    if( isset( $data[$module])) {
                        if(array_search('on', $data[$module]) ) {
                            return true;
                        }
                    }
                }
                
            }
        }
        return false;
    }   
    
}

function get_studentCount_byCategory($category_id, $class) {
    $query = DB::table('order_items')
                ->selectRaw('students.standard,
                COUNT(CASE WHEN students.gender = "M" THEN orders.order_no END) AS males,
                  COUNT(CASE WHEN students.gender = "F" THEN orders.order_no END) AS females,
                  COUNT(*) AS Total')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->join('students', 'students.id', '=', 'orders.student_id')
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->join('product_categories', 'product_categories.id', '=', 'products.category_id')
                ->where('product_categories.id', $category_id)
                ->where('students.standard', $class)
                ->groupBy('students.standard')
                ->first();

    return $query;
                
}

function get_order_item_count($institute_id, $date, $category_id = '') {
    
    $query = DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->join('institutions', 'institutions.id', '=', 'orders.institute_id')
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->join('product_categories', 'product_categories.id', '=', 'products.category_id')
                ->where( 'institutions.id', $institute_id)
                ->whereDate('orders.created_at', $date )
                ->when($category_id != '', function($query) use ($category_id){
                    $query->where('product_categories.id', $category_id);
                })
                ->get();
    return $query;
}

function sendSMS($numbers,$board, $order_info)
{
    // $apiKey = urlencode('NTg1MjRjNDY1ODM4NTg1OTUwNGU3NzQ4MzQ3ODU5NGM=');
    // Message details
    $numbers = "91".$numbers;
    $sender = urlencode('AMALFOOD');
    if( strtolower($board) ==  'ala' ) {
        $message = 'Received Morning Breakfast Order No.'.$order_info->order_no.' dt.'.date('d/m/Y', strtotime($order_info->created_at)).' from '.$order_info->payer_name.'('.$order_info->payer_mobile_no.'). Thank you - ALA';
        $sender = 'ALApdy';
    } else {
        $message = 'Received Morning Breakfast Order No.'.$order_info->order_no.' dt.'.date('d/m/Y', strtotime($order_info->created_at)).' from '.$order_info->payer_name.'('.$order_info->payer_mobile_no.'). Thank you - Amalorpavam';
        $sender = 'AHSSpy';
    }
    
    // Prepare data for POST request
    // $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
    // Send the POST request with cURL
    $params = array('securitykey' => 'M7QDZXGKW6VTFXW2RH','mobile' => $numbers, 'message' => $message, 'sender' => $sender );
    return Http::get('https://1message.com/apis/api/quicksendmessage', $params);

    //https://1message.com/apis/api/quicksendmessage?securitykey=M7QDZXGKW6VTFXW2RH&mobile=9786188270&message=Received Morning Breakfast Order No.12345 dt.02/02/2022 from Pravin(123456789). Thank you - ALA&sender=ALApdy
    // sender=SENDER_ID&uniqueid=UNIQUE_ID&sendat=SENDAT
        
}