@extends('layouts.app')
@section('content')
<style>
    .pre-table {
        width:100%;
    }
    .pre-table td {
        padding: 20px;
        font-weight: 600;
        border-bottom: 1px solid #92ccea;
    }
</style>
    <main>
        <div class="menu">
            <div>
                
                <div class="card option_card border-0  col-lg-8 mx-auto" >
                    <div class="card-title">
                        Order Confirmation
                    </div>
                    
                    <div class="card-body mb-5 shadow-sm border">
                        <div class="confirmed_message">
                            <div class="fa fa-check-circle text-success fa-3x m-3"></div>
                            <p class="m-0">Your Order is confirmed. Your Order No <a target="_blank" href="{{ asset('storage/invoice_order/'.$info->order->order_no.'.pdf' ) }}">{{ $info->order->order_no }}</a>. Please find the Payment transaction details below</p>
                        </div>
                    </div>
                    @include('front_end.invoice.order_invoice')
                    
                    <div class="text-center mt-3" >
                        <a href="{{ route('online.student') }}" class="px-3 btn btn-primary">Go to Home</a>
                    </div>

                </div> 
            </div>
        </div>
    </main>
    <script>
        $('.razorpay-payment-button').addClass('w-100 btn btn-primary');
    </script>
@endsection