@extends('front_end.wizard.index')
@section('wizard_content')
<div class="wizard_menu col-lg-10 mx-auto"> 
    <!--========= Wizard Body  ======-->  
    <div class="col-lg-10 mx-auto ">
        <div class="card option_card shadow-sm ">
            <div class="card-body p-0">
                <div class="card-title">
                    Your Order
                </div> 
                
                

                <div id="order_info">
                    @include('front_end.wizard.confirm._order_info')
                </div>
                <div class="card-body mb-5 p-0" >
                    @include('front_end.wizard.common._student_info')
                </div>
                <form id="confirm_form" action="{{ route('confirm.food.payment') }}" method="POST">
                    @csrf
                    <div>
                        @include('front_end.wizard.confirm._payee_form')
                    </div>
                    <div class="mt-5">
                        <a href="{{ route('online.food') }}" class="px-3 btn btn-light border shadow-sm" id="previous" > Prev </a>
                        <button type="button" class="px-3 btn btn-primary float-end" id="confirm_pay_btn"> Confirm Payment </button>
                    </div>
                </form>
            </div> 
        </div>
    </div>
    <!--========= End : Wizard Body  ======-->  
</div>
<script>

    $('#previous').click(function(){
        // window.location.href="{{ route('online.food') }}";
    })

    $('#payee_name').keyup(function(){
        var cur = $(this).val();
        if( $(this).hasClass('error') ) {
            if( cur.length > 0 ) {
                $('#payee_name').removeClass('error');
            }
        }
    })

    $('#mobile_no').keyup(function(){
        var cur = $(this).val();
        if( $(this).hasClass('error') ) {
            if( cur.length > 0 ) {
                $('#mobile_no').removeClass('error');
            }
        }
    })
    

    $("#confirm_pay_btn").click(function() {
        $('#loading').show();
        var payee_name = $('#payee_name').val();
        var mobile_no = $('#mobile_no').val();
        error = false;
        if( payee_name == undefined || payee_name == '' || payee_name == null ){
            $('#payee_name').addClass('error');
            error = true;
        } else {
            $('#payee_name').removeClass('error');
        }

        if( mobile_no == undefined || mobile_no == '' || mobile_no == null ){
            $('#mobile_no').addClass('error');
            error = true;
        } else {
            $('#mobile_no').removeClass('error');
        }
        // console.log( error );
        if( error ) {
            $('#loading').hide();

            return false;
        }
        var form = $('#confirm_form').submit();
        
       	

    });
</script>
@endsection
