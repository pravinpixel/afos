@extends('layouts.app')
@section('content')
<main>
    <!--========= Wizard Header  ======-->
    <style>
        .error {
            border:1px solid red !important;
        }

        #loading {
            position: fixed;
            display: block;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            text-align: center;
            opacity: 0.7;
            background-color: #fff;
            z-index: 99;
        }

        #loading-image {
            position: absolute;
            top: 10%;
            left: 26%;
            z-index: 100;
        }
    </style>
    <div class="col-lg-8 mx-auto"></div>
        @include('front_end.wizard.common._wizard_route')
    </div>
    <!--========= End : Wizard Header ======-->
    <div class="menu">
        @yield('wizard_content')
    </div>

    <div id="loading" >
        <img id="loading-image" src="https://flevix.com/wp-content/uploads/2019/12/Barline-Loading-Images-1.gif" alt="Loading..." />
    </div>
</main>
<script>
    $(window).on('load', function () {
        $('#loading').hide();
    })
    $(document).on("input", ".price", function() {
    this.value = this.value.match(/^\d+\.?\d{0,2}/);});

    $(document).on("input", ".numberonly", function() {
    this.value = this.value.match(/^\d+/);});

    // studentinfo wizard functions
    $('#change_student').click(function(){

        Swal.fire({
            title: 'Are you sure?',
            text: "Your data will be cleared",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('order.student.change') }}",
                    type: 'POST',
                    beforeSend: function(){
                        $('#loading').show();
                    },
                    success: function(response) {
                        if( response ){
                            Swal.fire(
                            'Changed!',
                            'Your Data has been cleared.',
                            'success'
                            );
                            setTimeout(() => {
                                $('#loading').hide();

                                window.location.href="{{ route('online.student') }}" 
                            }, 2000);
                            
                        }
                    }            
                });
            }
        })
    });

    function delete_food(item_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Your item will be cleared",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('order.delete.food') }}",
                    type: 'POST',
                    data: {item_id:item_id},
                    success: function(response) {
                        
                        if( response.error == 0 ){
                            Swal.fire(
                            'Changed!',
                            'Your Data has been cleared.',
                            'success'
                            )
                            get_order_list()
                            
                        } else {
                            Swal.fire(
                            'Failed!',
                            response.message,
                            'error'
                            )
                        }
                    }            
                });
            }
        })
    }

    function get_order_list() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('order.food.list') }}",
            type: 'POST',
            success: function(response) {
                if( response ){
                    $('#order_info').html(response);
                }
            }            
        });
    }

    
</script>
@endsection
