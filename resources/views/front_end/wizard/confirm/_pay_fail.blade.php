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
                
                <div class="card option_card border-0  col-lg-12 mx-auto" >
                    <div class="card-title">
                        Order Payment Cancellation
                    </div>
                    <div>
                        @include('flash::message') 
                    </div>
                    
                    <div class="text-center mt-3" >
                        <a href="{{ url('/') }}" class="px-3 btn btn-primary">Retry</a>
                    </div>

                </div> 
            </div>
        </div>
    </main>
    <script>
        $('.razorpay-payment-button').addClass('w-100 btn btn-primary');
    </script>
@endsection