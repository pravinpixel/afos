@extends('backend.layout.template')
@section('content')

<div class="row">

    <!-- Right Sidebar -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Left sidebar -->
                <div class="page-aside-left">
                    <div class="email-menu-list mt-3">
                        <a href="#" id="myaccount" class="list-group-item p-2 bg-light"><i class="dripicons-user  font-18 align-middle me-2"></i>My Account</a>
                        {{-- <a href="#" id="email" class="list-group-item p-2"><i class="mdi mdi-google-drive font-18 align-middle me-2"></i> Email </a> --}}
                        {{-- <a href="#" id="sms" class="list-group-item p-2"><i class="mdi mdi-dropbox font-18 align-middle me-2"></i> SMS </a> --}}
                        {{-- <a href="#" id="payment" class="list-group-item p-2"><i class="mdi mdi-dropbox font-18 align-middle me-2"></i> Payment </a> --}}
                        <a href="#" id="global" class="list-group-item p-2"><i class="dripicons-gear  font-18 align-middle me-2"></i>Global Settings</a>
                        <a href="#" id="password" class="list-group-item p-2"><i class="dripicons-gear  font-18 align-middle me-2"></i>Change Password</a>
                    </div>
                </div>
                <!-- End Left sidebar -->

                <div class="page-aside-right" style="position: relative">

                    <div class="mt-3" id="ajax_tab">
                        
                    </div> <!-- end .mt-3-->
                    <div class="set_loader" style="display: none;"></div>
                </div> 
                <!-- end inbox-rightbar-->
            </div>
            <!-- end card-body -->
            <div class="clearfix"></div>
        </div> <!-- end card-box -->

    </div> <!-- end Col -->
</div><!-- End row -->


@endsection

@section('add_on_script')
<script>
    
    get_set_tab('myaccount');
    $('.list-group-item').click(function(){
        $('.list-group-item').removeClass('bg-light');
        $(this).addClass('bg-light');
        var tab_type = $(this).attr('id');
        get_set_tab(tab_type);

    })

    function get_set_tab(tab_type) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('get-tab') }}",
            type: "POST",
            data: {tab_type:tab_type},
            beforeSend:function(){
                $('.set_loader' ).show();
                $( '#ajax_tab').addClass('blur');
                // $('#save').off('click');
            },
            success:function(response) {
                $('.set_loader' ).hide();
                // $('#save').on('click');
                $( '#ajax_tab').removeClass('blur');
                $('#ajax_tab').html(response);
            }
        });
    }
</script>
@endsection




                        

                    