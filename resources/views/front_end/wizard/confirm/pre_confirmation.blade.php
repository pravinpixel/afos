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
            <div class="col-lg-4 col-md-6 mx-auto">
                <div class="card option_card shadow-sm">
                    <div class="card-body p-0">
                        <div class="card-title">
                            Order Pre Confirmation
                        </div>
                        @if($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>Error!</strong> {{ $message }}
                            </div>
                        @endif

                       

                        <form action="{{ route('final.process') }}" method="POST" >  
                            <div>
                                <table class="pre-table">
                                    <tr>
                                        <td style="width: 50%">Payee Name</td>
                                        <td> {{ $payee_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Payee Mobile</td>
                                        <td> {{ $payee_mobile  }}</td>
                                    </tr>
                                    <tr>
                                        <td> Amount </td>
                                        <td> Rs. {{ $original_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="hidden" name="_token" value="{!!csrf_token()!!}" class="w-100 btn btn-primary">
                                        </td>
                                    </tr>
                                </table>
                            </div>                      
                            <script src="https://checkout.razorpay.com/v1/checkout.js"
                                    data-key="{{ env('RAZOR_KEY') }}"
                                    data-amount="{{ $amount }}"
                                    data-buttontext="{{ $buttontext }}"
                                    data-name="{{ $name }}"
                                    data-description="Secure Payment"
                                    data-image="https://amalpay.in/resources/assets/images/logo1.png"
                                    data-prefill.name="{{ $payee_name }}"
                                    data-prefill.contact="{{ $payee_mobile }}"
                                    data-theme.color="#528FF0">
                            </script>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        $('.razorpay-payment-button').addClass('w-100 btn btn-primary');
    </script>
@endsection