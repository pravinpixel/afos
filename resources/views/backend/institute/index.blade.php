@extends('backend.layout.template')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    @if (check_user_access('institutes', 'editable'))
                    <div class="col-sm-12 text-end">
                        <a href="javascript:void(0);" class="btn btn-primary mb-2" onclick="return add_modal()" id="add-user" data-id="3">
                            <i class="mdi mdi-plus-circle me-2"></i> Add Institute</a>
                    </div>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap" id="institutes-table">
                        <thead class="table-light">
                            <tr>
                               
                                <th>Institute</th>
                                <th>Code</th>
                                <th>Location</th>
                                <th> Status </th>
                                <th style="width: 75px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>


@endsection
@section('third_party_js')
     <!-- third party js -->
     <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js' ) }}"></script>
     <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js' ) }}"></script>
     <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js' ) }}"></script>
     <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js' ) }}"></script>
     <script src="{{ asset('assets/js/vendor/apexcharts.min.js' ) }}"></script>
     <script src="{{ asset('assets/js/vendor/dataTables.checkboxes.min.js' ) }}"></script>
     <!-- third party js ends -->
      <!-- demo app -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> 

      <!-- end demo js-->

@endsection
@section('add_on_script')
<script>
   
    var table = $('#institutes-table').DataTable({
        processing: true,
        serverSide: true,
        type: 'POST',
        ajax: "{{ route('institutes') }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'institute_code', name: 'institute_code'},
            {data: 'location', name: 'location'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    function add_modal(id='') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('institutes.add_edit') }}",
            type: "POST",
            data: {id:id},
            success:function(response) {
               $('#standard-modal').html(response);
               $('#standard-modal').modal('show');
            }
        });

    }

    function delete_institute(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('institutes.delete') }}",
                    type: "POST",
                    data: {id:id},
                    success:function(res){
                        if( res ) {
                            Swal.fire(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                                )
                            table.ajax.reload();
                        }
                    }
                });
                
            }
        })
    }

    function change_status(id, status) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You can be able to change again!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('institutes.status') }}",
                    type: "POST",
                    data: {id:id, status:status},
                    success:function(res){
                        if( res ) {
                            Swal.fire(
                                'Changed!',
                                'Your Institute status has been changed.',
                                'success'
                                )
                            table.ajax.reload();
                        }
                    }
                });
                
            }
        })
    }



</script>
@endsection




                        

                    