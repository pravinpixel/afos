<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="standard-modalLabel">{{ $title ?? '' }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <form id="userform" method="POST" action="{{ route('institutes.save')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$id??''}}">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="name"> Institute Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $info->name ?? '' }}"  required />
                        </div>
                        <div class="mb-3">
                            <label for="institute_code"> Institute Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="institute_code" name="institute_code" value="{{ $info->institute_code ?? '' }}" required />
                        </div>
                        
                        <div class="mb-3">
                            <label for="location_id ">Location <span class="text-danger">*</span></label>
                            <select name="location_id" id="location_id" required class="form-control">
                                <option value="">-- select --</option>
                                @if( isset( $location ) && !empty($location))
                                    @foreach ($location as $item)
                                        <option value="{{ $item->id }}" @if( isset( $info->location_id ) && $info->location_id == $item->id) selected @endif>{{ $item->location_name }}</option>
                                    @endforeach
                                @endif
                                
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name">Description </label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ $info->description ?? '' }}</textarea>
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
