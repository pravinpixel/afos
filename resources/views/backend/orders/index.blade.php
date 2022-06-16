@extends('backend.layout.template')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap" id="order-table">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th> Register No </th>
                                <th> Board </th>
                                <th> Student </th>
                                <th>Order No</th>
                                <th>Amount</th>
                                <th>Status</th>
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
   
   var table = $('#order-table').DataTable({
        processing: true,
        serverSide: true,
        type: 'POST',
        ajax: "{{ route('orders') }}",
        columns: [
            {data: 'date', name: 'date'},
            {data: 'register_no', name: 'register_no'},
            {data: 'board', name: 'board'},
            {data: 'student', name: 'student'},
            {data: 'order_no', name: 'order_no'},
            {data: 'total_price', name: 'amount'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: [],
    });

    function view_modal(id) {
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('orders.view') }}",
            type: "POST",
            data: {id:id},
            success:function(response) {
                
               $('#standard-modal').html(response);
               $('#standard-modal').modal('show');
            }
        });
    }

</script>
@endsection




                        

                    