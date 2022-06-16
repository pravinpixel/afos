<h5 class="mb-2">Razor Pay - Payment Information</h5>
<form id="emailform" action="{{ route('settings.save') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        <h5>Payment Mode</h5>
        <div class="col-4">
            <div class="mb-3">
                <div class="form-check form-checkbox-success mb-2">
                    <input type="checkbox" name="payemnt_live" class="form-check-input " @if(setting('payment', 'payemnt_live') == 'on' ) checked @endif id="customCheckcolor2" style="width: 30px;height: 30px;">
                    <label class="form-check-label ms-2 mt-1" for="customCheckcolor2"> Enable Sms </label>
                </div>
            </div>
        </div>
        <h5>Test Details</h5>
        <div class="col-6">
            <div class="mb-3">
                <input type="hidden" name="type" value="payment">
                <label for="access_key">Access Key <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="access_key" name="test_access_key" value="{{ setting('payment', 'test_access_key') }}" required />
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="security_key"> Security Key <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="security_key" name="test_security_key" value="{{ setting('payment', 'test_security_key') }}" required />
            </div>
        </div>
        <h5> Live Details</h5>
        <div class="col-6">
            <div class="mb-3">
                <input type="hidden" name="type" value="payment">
                <label for="access_key">Access Key <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="access_key" name="access_key" value="{{ setting('payment', 'access_key') }}" required />
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="security_key"> Security Key <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="security_key" name="security_key" value="{{ setting('payment', 'security_key') }}" required />
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
                            get_set_tab('payment');
                        } else {
                            toastr.error('Error', response.message);
                        }
                        
                    }            
                });		
                
            }
        });
    })
</script>