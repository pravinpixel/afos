<?php 

function test() {
    echo 'durair';
}

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
    $module = $request->route()->getName(); 
    
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
            return true;
        }
    }
    abort(403);
}