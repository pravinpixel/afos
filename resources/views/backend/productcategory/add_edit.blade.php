<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="standard-modalLabel">{{ $title ?? '' }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <form id="userform" method="POST" action="{{ route('product-category.save')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$id??''}}">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="name">Category <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="category" name="category" value="{{ $info->categories ?? '' }}" required />
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="cutoff_start_time"> Cutoff Start Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="cutoff_start_time" name="cutoff_start_time" value="{{ $info->cutoff_start_time ?? '' }}" required />
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="cutoff_end_time"> Cutoff End Time  <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="cutoff_end_time" name="cutoff_end_time" value="{{ $info->cutoff_end_time ?? '' }}" required />
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="order"> Order <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="order" name="order" min="1" value="{{ $info->order ?? '' }}" required />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="name">Description </label>
                            <textarea name="description" id="description" cols="30" rows="3" class="form-control">{{ $info->description ?? '' }}</textarea>                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="save">Save changes</button>
            </div>
        </form>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    
    $(document).ready(function(){
        $("#userform").validate({
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
                            $('#standard-modal').modal('hide');
                            table.ajax.reload();
                        } else {
                            toastr.error('Error', response.message);
                        }
                        
                    }            
                });		
                
            }
        });
    })
</script>
