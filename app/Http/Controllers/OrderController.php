<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Institution;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Validator;
use Auth;
use Carbon\Carbon;
use DB;
use Razorpay\Api\Api;
use Exception;

use PDF;
use Illuminate\Support\Facades\Storage;



class OrderController extends Controller
{
    public function index()
    {
        
        $institution = Institution::where('status', 1 )->get();
        $info = '';
        if(session()->get('order') ) {
            $session = session()->get('order');
            if( isset($session['student_id'])){
                $info = Student::find($session['student_id']);
            }
        }
        return view('front_end.wizard.students.index', compact('institution', 'info'));
    }

    public function get_food_info() {
        if( session()->get('order')) {
            // DB::enableQueryLog();
            $items = ProductCategory::with('products')->cutoff()->orderBy('order')->where('status', 1)->get();
            // dd(DB::getQueryLog());
            return view('front_end.wizard.food.index', compact('items'));
        } 
        abort(404);
    }

    public function order_info(Request $request ) {
        if( session()->get('order')) {
            $session = session()->get('order');
            // dd( $session );
            $student_id = $session['student_id'];
            $product_id = $session['product_id'];
            $info = Student::find($student_id);
            $items = Product::whereIn('id', $product_id)->get();
            return view('front_end.wizard.confirm.index', compact('info', 'items'));
        } else {
            abort(404);
        }
    }

    public function confirmation() {
        return view( 'front_end.wizard.confirmation');
    }

    public function check_student(Request $request) {
        
        $institute = $request->institute;
        $register_no = $request->register_no;
        $dob = $request->dob;
        $info = Student::where('register_no', $register_no)->where('institute_id', $institute)->where('dob', $dob)->first();
        if( isset( $info ) && !empty($info)) {
            $id = $info->id;
            $error = 0;
        } else {
            $error = 1;
            $id = '';
        }
        $response = array('error' => $error, 'id' => $id );
        return $response;
    }

    public function student_list(Request $request) {
        $student_id = $request->student_id;

        $info = Student::find($student_id);
        return view('front_end.wizard.students.info', compact('info'));
    }

    public function initialize_order(Request $request) {
        
        $id = $request->id;

        $info = Student::find($id);
        if( session()->get('order')) {
            $session = session()->get('order');
        }
        $session['student_id'] = $id;
        session()->put('order', $session);
        echo 1;
    }

    public function change_student(Request $request) {
        session()->forget('order');
        echo 1;
    }

    public function select_food(Request $request) {

        $validator = Validator::make($request->all(), [
            'food' => 'required',
        ]);

        if ($validator->passes()) {
            
            if( session()->get('order')) {
                $session = session()->get('order');
            }
            $session['product_id'] = $request->food;
            session()->put('order', $session);

            $error = 0;
            $message = '';
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error'=> $error, 'message' => $message]);
    }

    public function delete_food(Request $request) {
        $item_id = $request->item_id;
        $view = '';
        if( session()->get('order')) {
            $session = session()->get('order');
            $order_items = $session['product_id'];

            if( count($order_items) <= 1 ) {
                $error = 1;
                $message = 'You cannot delete food, atleast have one food';
            } else {
                if( isset( $order_items ) && !empty( $order_items ) ) {
                    $key = array_search($item_id, $order_items);
                    unset($order_items[$key]);
    
                    $session['product_id'] = $order_items;
                    session()->put('order', $session);
                    $items = Product::whereIn('id', $order_items)->get();
                    $error = 0;
                    $message = '';
                    $view = view('front_end.wizard.confirm._order_info', compact('items'));
                }
            }
            $response = array('error' => $error, 'message' => $message, 'view' => $view );
            return $response;
        } 
        abort(404);
    } 

    public function order_list(Request $request) {
        if( session()->get('order')) {
            $session = session()->get('order');
            
            $order_items = $session['product_id'];
            $items = Product::whereIn('id', $order_items)->get();
            
            return view('front_end.wizard.confirm._order_info', compact('items'));
        }
        abort(404);
    }

    public function confirm_payment(Request $request) {
        
        $payee_name = $request->payee_name;
        $payee_contact = $request->mobile_no;
        if( session()->get('order')) {
            $session = session()->get('order');

            $order_items = $session['product_id'];
            $items = Product::selectRaw('sum(price) as price')->whereIn('id', $order_items)->first();

            $student_id = $session['student_id'];
            $item_all = Product::whereIn('id', $order_items)->get();

            //insert in 
            $stu_info = Student::find($student_id);
            $ins['order_no'] = order_no();
            $ins['payer_name'] = $payee_name;
            $ins['payer_mobile_no'] = $payee_contact;
            $ins['student_id'] = $student_id;
            $ins['institute_id'] = $stu_info->institute_id;
            $ins['total_price'] = $items->price;
            $ins['status']      = 2;

            $order_id = Order::create($ins)->id;
                
            if( isset( $item_all ) && !empty( $item_all )) {
                foreach ($item_all as $its) {
                    $itins['order_id'] = $order_id;
                    $itins['product_id'] = $its->id;
                    $itins['price'] = $its->price;

                    OrderItem::create($itins);
                }
            }
            $amount = $items->price * 100;
            // $amount = 1 * 100;
            //insert in payment
            $pay['order_id']        = $order_id;
            $pay['transaction_no']  = 'TNX'.date('hisdmy');
            $pay['amount']          = $items->price;
            // $pay['response']        = serialize($response);

            $payment_id             = Transaction::create($pay)->id;

            $session['payment_id'] = $payment_id;
            $session['amount'] = $items->price;
           
            session()->put('order', $session);

            $params =array(
                'amount' => $amount, 
                'buttontext' => 'Pay '.$items->price.' INR', 
                'name' => 'Amalorpavam Lourds Academy', 
                'payee_name' => $payee_name,
                'payee_mobile' => $payee_contact,
                'original_amount' => $items->price,
            );
            return view('front_end.wizard.confirm.pre_confirmation', $params);
        }
        abort(404);
    }

    public function final_process(Request $request) {
        $input = $request->all();
  
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
  
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        
        if( session()->get('order')) {
            $session = session()->get('order');
            
            $payment_id = $session['payment_id'];
            $pay_info = Transaction::find($payment_id);
            $order = Order::find($pay_info->order_id);
            
            if(count($input)  && !empty($input['razorpay_payment_id'])) {
                try {
                    $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
                    
                    $pay_info->response = serialize($response);
                    $pay_info->payment_status = 'success';
                    $pay_info->update();

                    $order->status = 1;
                    $order->update();
                    // session()->forget('order');

                } catch (Exception $e) {

                    $pay_info->response = serialize($e->getMessage());
                    $pay_info->payment_status = 'failed';
                    $pay_info->update();

                    $order->status = 4; ///faild payment
                    $order->update();
                    session()->forget('order');
                    
                    \Flash::info($e->getMessage());
                    return redirect()->route('fail.page');
                }
            }
            session()->put('success_pay_id', $payment_id);
            return redirect()->route('success.page');
        } 
        abort(404);        
    }

    public function success_page(Request $request) {

        if( session()->flash('pay_success')) {
            if( session()->get('success_pay_id')){
                $paymet_id = session()->get('success_pay_id');
                $payment_info = 
                session()->forget('success_pay_id');
            }
        }

        if( session()->get('order')) {
            
            $paymet_id = session()->get('order')['payment_id'];
            $info = Transaction::find($paymet_id);

            $mess = "Received ";
		
		    $sms= sendSMS($info->order->payer_mobile_no, $info->order->student->board, $info->order );
            
            $pdf = PDF::loadView('front_end.invoice.order_invoice', compact('info'));    
            Storage::put('public/invoice_order/'.$info->order->order_no.'.pdf', $pdf->output());
            session()->forget('order');
            return view('front_end.wizard.confirm._pay_success', ['info' => $info ?? '']);
        }
        abort(404);

    }

    public function fail_page(Request $request) {
        return view('front_end.wizard.confirm._pay_fail');
    }

    public function generatePDF()
    {
        $info  = Transaction::find(22);
        $pdf = PDF::loadView('front_end.invoice.order_invoice', compact('info'));    
        Storage::put('public/invoice_order/invoice1.pdf', $pdf->output());    
        // return $pdf->download('test.pdf');1
    }
}