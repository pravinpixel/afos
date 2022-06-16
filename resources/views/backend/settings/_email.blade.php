<h5 class="mb-2">Email Configuration</h5>
<form id="emailform" action="{{ route('settings.save') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-6">
            <div class="mb-3">
                <input type="hidden" name="type" value="email">
                <label for="host">Host <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="host" name="host" value="{{ setting('email', 'host') }}"  required />
            </div>
            <div class="mb-3">
                <label for="user_name">User Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="{{ setting('email', 'user_name') }}" required />
            </div>
            <div class="mb-3">
                <label for="password"> Password <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="password" name="password" value="{{ setting('email', 'password') }}"  required />
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="port"> Port <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="port" name="port" value="{{ setting('email', 'port') }}"  required />
            </div>
            
            <div class="mb-3">
                <label for="encryption"> Encryption <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="encryption" name="encryption" value="{{ setting('email', 'encryption') }}"  required />
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
                            get_set_tab('email');
                        } else {
                            toastr.error('Error', response.message);
                        }
                        
                    }            
                });		
                
            }
        });
    })
</script>