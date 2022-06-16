@extends('front_end.wizard.index')
@section('wizard_content')
<div class="wizard_menu col-lg-10 mx-auto"> 
    <!--========= Wizard Body  ======-->  
    <div class="col-lg-10 mx-auto">
        <div class="card option_card shadow-sm">
            <div class="card-body p-0">
                <div class="card-title">
                    Choose your food 
                    @php
                    // if( isset(session()->get('order')['product_id'] ) ){
                    //     print_r( session()->get('order')['product_id'] );
                    // }
                    @endphp
                </div>
                <form id="food_form" method="POST" action="{{ route('order.select.food')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row food_list">
                        @include('front_end.wizard.food._product_items')
                    </div> 
                    <div class="mt-3">
                        <a href="{{ route('online.student') }}" class="px-3 btn btn-light border shadow-sm">Prev</a>
                        {{-- <a href="confirm-order.html" class="px-3 btn btn-primary float-end">Next</a> --}}
                        <button type="button" id="select_food" class="px-3 btn btn-primary float-end"> Next </button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <strong class="text-danger " id="error_msg"></strong>
                </div>
            </div> 
        </div>
    </div>
    <!--========= End : Wizard Body  ======-->  
</div>
<script>
    $("#select_food").click(function() {

        var form = $('#food_form')[0]
        var formData = new FormData(form);
        $.ajax({
            url: form.action,
            type: form.method,
            data: formData,
            contentType: false,
            processData: false,
            beforeSend:function(){
                $('#select_food').attr('disabled', true);
                $('#loading').show();
            },
            success: function(response) {
                $('#select_food').attr('disabled', false);
                
                if( response.error == 1 ){
                    $('#loading').hide();
                    $('#error_msg').show();
                    $('#error_msg').html('Atleast one food need to select');
                    $('#error_msg').fadeOut(5000);
                } else {
                    window.location.href="{{ route('confirm.order') }}";
                }
            }            
        });		

    });
</script>
@endsection
