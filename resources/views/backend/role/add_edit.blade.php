<div class="modal-dialog modal-full-width">
    <style>
        .table-role thead {
            background: var(--bs-app-grade);
            color: white;
        }
        .table-role td {
            padding: 0px;
            text-align:center;
        }
        .table-role th {
            padding: 5px;
            text-align: center;
        }
    </style>
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="standard-modalLabel">{{ $title ?? '' }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <form id="roleform" method="POST" action="{{ route('roles.save')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$id??''}}">
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="name">Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $info->name ?? '' }}" required />
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="name">Role Description </label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ $info->description ?? '' }}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped table-bordered table-hover table-role" padding="0">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-start px-3"> Module </th>
                                    <th> Visible </th>
                                    <th> Editable </th>
                                    <th> Delete </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div>
                                            <input type="checkbox" id="all_view" >
                                            <label class="ml-2" for="all_view"> All </label>
                                        </div>
                                    </th>
                                    <th>
                                        <div>
                                            <input type="checkbox" id="all_edit" >
                                            <label for="all_edit"> All </label>
                                        </div>
                                    </th>
                                    <th>
                                        <div>
                                            <input type="checkbox" id="all_delete" >
                                            <label for="all_delete"> All </label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $perms = [];
                                    if( isset( $info->permissions ) && !empty($info->permissions)) {
                                        $perms = unserialize($info->permissions);
                                    }
                                @endphp
                                @if( config('constant.permission') )
                                    @foreach (config('constant.permission') as $item)
                                        <tr>
                                            <td class="text-start px-3">
                                                {{ ucwords( str_replace('-', " ",$item ) ); }}
                                                <input type="hidden" name="item" value="{{$item??''}}">
                                            </td>
                                            <td>
                                                <input type="checkbox" class="visible" @if(isset( $perms[$item][$item.'_visible']) && $perms[$item][$item.'_visible'] == 'on') checked @endif name="{{$item}}_visible" id="{{$item}}_visible">
                                            </td>
                                            <td>    
                                                <input type="checkbox" class="editable" @if(isset( $perms[$item][$item.'_editable']) && $perms[$item][$item.'_editable'] == 'on') checked @endif name="{{$item}}_editable" id="{{$item}}_editable">
                                            </td>
                                            <td>
                                                <input type="checkbox" class="delete" @if(isset( $perms[$item][$item.'_delete']) && $perms[$item][$item.'_delete'] == 'on') checked @endif name="{{$item}}_delete" id="{{$item}}_delete">
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
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
    $('#all_view').click(function(){
        if( $('#all_view').is(":checked")) {
            $('.visible').attr('checked', true);
        } else {
            $('.visible').attr('checked', false);
        }
    });

    $('#all_edit').click(function(){
        if( $('#all_edit').is(":checked")) {
            $('.editable').attr('checked', true);
        } else {
            $('.editable').attr('checked', false);
        }
    });

    $('#all_delete').click(function(){
        if( $('#all_delete').is(":checked")) {
            $('.delete').attr('checked', true);
        } else {
            $('.delete').attr('checked', false);
        }
    });
    
    $(document).ready(function(){
        $("#roleform").validate({
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
