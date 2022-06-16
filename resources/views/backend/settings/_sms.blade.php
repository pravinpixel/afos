<h5 class="mb-2">SMS Configuration</h5>
<form id="emailform" action="{{ route('settings.save') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-4">
            <input type="hidden" value="sms" name="type">
            <div class="mb-3">
                <label for="security_key">Security Key <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="security_key" name="security_key" value="{{ setting('sms', 'security_key') }}" required />
            </div>
        </div>
        <div class="col-4">
            <div class="mb-3">
                <label for="sender_id">Sender Id <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="sender_id" name="sender_id" value="{{ setting('sms', 'sender_id') }}" required />
            </div>
        </div>
        <div class="col-4">
            <div class="mb-3">
                <div class="form-check form-checkbox-success mb-2">
                    <label class="form-check-label" for="customCheckcolor2">Enable Sms </label>
                    <div class="ms-3">
                        <input type="checkbox" name="enable_sms" class="form-check-input " @if(setting('sms', 'enable_sms') == 'on' ) checked @endif id="customCheckcolor2" style="width: 30px;height: 30px;">
                    </div>
                </div>
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
                            get_set_tab('sms');
                        } else {
                            toastr.error('Error', response.message);
                        }
                        
                    }            
                });		
                
            }
        });
    })
</script>