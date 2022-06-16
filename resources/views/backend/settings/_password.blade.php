<h5 class="mb-2">Change Password</h5>
<form id="emailform" action="{{ route('password.save') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label for="old_password"> Old Password  <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="old_password" name="old_password"  required />
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label for="password"> Password  <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password"  required />
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label for="password_confirmation"> Confirm Password  <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"  required />
            </div>
        </div>
        <div class="col-12 text-end">
            <button type="submit" id="save" class="btn btn-primary"> Submit </button>
        </div>
    </div>
</form>
<script>
    $(document).ready(function(){
        $("#emailform").validate({
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
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                            get_set_tab('password');
                        } else {
                            toastr.error('Error', response.message);
                        }
                        
                    }            
                });		
                
            }
        });
    })
</script>