<h5 class="mb-2">Global Settings</h5>
<form id="emailform" action="{{ route('settings.save') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-6">
            <input type="hidden" name="type" value="global">
            <div class="mb-3">
                <label for="site_email">Site Email <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="site_email" name="site_email" value="{{ setting('global', 'site_email') }}" required />
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="site_contact">Site Contact <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="site_contact" name="site_contact" value="{{ setting('global', 'site_contact') }}" required />
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
                            get_set_tab('global');
                        } else {
                            toastr.error('Error', response.message);
                        }
                        
                    }            
                });		
                
            }
        });
    })
</script>