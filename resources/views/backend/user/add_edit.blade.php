<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="standard-modalLabel">{{ $title ?? '' }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <form id="userform" method="POST" action="{{ route('users.save')}}" enctype="multipart/form-data">
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
                            <label for="name">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $info->email ?? '' }}" required  />
                        </div>
                        <div class="mb-3">
                            <label for="mobile_no">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="{{ $info->mobile_no ?? '' }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="role">Role <span class="text-danger">*</span></label>
                            <select name="role_id" id="role_id" required class="form-control">
                                <option value="">-- select --</option>
                                @if( isset( $role ) && !empty($role))
                                    @foreach ($role as $item)
                                      <option value="{{ $item->id }}" @if( isset($info->role_id) && $info->role_id == $item->id) selected @endif >{{ $item->name }}</option>  
                                    @endforeach
                                @endif
                            </select>
                        </div>
                       
                    </div>
                    <div class="col-6">
                        @if (isset($id) && !empty($id))
                            
                        @else
                            <div class="mb-3">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="password" name="password" required />
                            </div>
                        @endif
                        
                        <div>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="row mt-3">
                            <div class="mt-3 text-center">
                                @if( isset( $info->image ) && !empty( $info->image ) )
                                <img src="{{ asset( 'images/'.$info->image )}}" width="100" alt="" class="rounded-circle">
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
