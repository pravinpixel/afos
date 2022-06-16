<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="standard-modalLabel">{{ $title ?? '' }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <form id="userform" method="POST" action="{{ route('products.save')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$id??''}}">
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $info->name ?? '' }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="category">Category <span class="text-danger">*</span></label>
                            <select name="category" id="category" class="form-control" required>
                                <option value="">--select--</option>    
                                @if( isset( $category ) && !empty( $category ) ) 
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}" @if( isset( $info->category_id ) && $info->category_id == $item->id ) selected @endif>{{ $item->categories }}</option>
                                    @endforeach
                                @endif
                            </select>                            
                        </div>
                        <div class="mb-3">
                            <label for="description"> Description </label>
                            <textarea name="description" id="description" cols="30" rows="3" class="form-control">{{ $info->description ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="price">Price <span class="text-danger">*</span></label>
                            <input type="text" class="form-control price" id="price" name="price" value="{{ $info->price ?? '' }}" required />
                        </div>
                        <div>
                            <input type="file" name="image" id="image" class="form-control" @if( isset( $info->image ) && !empty($info->image)) @else required @endif>
                        </div>
                        <div><span>Image size in pixel (565 x 280)</span></div>
                        <div class="row mt-3">
                            <div class="mt-3 text-center">
                                @if( isset( $info->image ) && !empty($info->image))
                                <img src="{{ asset('products/'.$info->image )}}" width="100" alt="" class="rounded-circle">
                                @else
                                    <img src="{{ asset('assets/images/no-user.png' )}}" width="100" alt="" class="rounded-circle">
                                @endif
                                
                            </div>
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
