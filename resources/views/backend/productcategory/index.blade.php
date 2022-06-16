@extends('backend.layout.template')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-12 text-end">
                        <a href="javascript:void(0);" class="btn btn-primary mb-2" onclick="return add_modal()" id="add-productcategory" data-id="3">
                            <i class="mdi mdi-plus-circle me-2"></i> Add Product Category</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap" id="productcategory-table">
                        <thead class="table-light">
                            <tr>
                                <th>Category</th>
                                <th>Order</th>
                                <th> CutOff Start Time</th>
                                <th> CutOff End Time</th>
                                <th> Status</th>
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
    var table = $('#productcategory-table').DataTable({
        processing: true,
        serverSide: true,
        type: 'POST',
        ajax: "{{ route('product-category') }}",
        columns: [
            {data: 'categories', name: 'categories'},
            {data: 'order', name: 'order'},
            {data: 'cutoff_start_time', name: 'cutoff_start_time'},
            {data: 'cutoff_end_time', name: 'cutoff_end_time'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: [],
    });
    
    function add_modal(id='') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('product-category.add_edit') }}",
            type: "POST",
            data: {id:id},
            success:function(response) {
               $('#standard-modal').html(response);
               $('#standard-modal').modal('show');
            }
        });

    }

    function delete_category(id) {
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
                    url: "{{ route('product-category.delete') }}",
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
                    url: "{{ route('product-category.status') }}",
                    type: "POST",
                    data: {id:id, status:status},
                    success:function(res){
                        if( res ) {
                            Swal.fire(
                                'Changed!',
                                'Your Product Category status has been changed.',
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




                        

                    