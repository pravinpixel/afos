<h5 class="mb-2">My Account</h5>

<div class="row">
    <div class="col-12">
        <form id="accountform" action="{{ route('account.save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-6">
                    
                    <div class="mb-3">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user_info->name ?? '' }}" placeholder="Admin" required />
                    </div>
                    <div class="mb-3">
                        <label for="name">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user_info->email ?? '' }}" disabled required  />
                    </div>
                    <div class="mb-3">
                        <label for="mobile_no">Mobile Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="{{ $user_info->mobile_no ?? '' }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="mobile_no">Address <span class="text-danger">*</span></label>
                        <textarea name="address" id="address" class="form-control" cols="30" rows="5">{{ $user_info->address ?? '' }}</textarea>
                    </div>
                </div>
                <div class="col-5">
                    <div>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <div class="row mt-3">
                        <div class="mt-3 text-center">
                            @if( isset( $user_info->image ) && !empty( $user_info->image ) )
                            
                            <img src="{{ asset( 'images/'.$user_info->image ) }}" width="150" alt="" class="rounded-circle">
                            @else
                            <img src="{{ asset('assets/images/no-user.png') }}" width="150" alt="" class="rounded-circle">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" id="save" class="btn btn-primary"> Submit </button>
                </div>
            </div>
            
        </form>
    </div>    
    
</div>
<script>
    $(document).ready(function(){
        $("#accountform").validate({
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        $('#save').html('Loading...');
                        $('#save').attr('disabled', true);
                    },
                    success: function(response) {
                        $('#save').html('Save changes');
                        $('#save').attr('disabled', false);
                        console.log( response );
                        if( response.error == 0 ) {
                            toastr.success('Success', response.message);
                            get_set_tab('myaccount');
                        } else {
                            toastr.error('Error', response.message);
                        }
                        
                    }            
                });		
                
            }
        });
    })
</script>