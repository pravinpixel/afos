@extends('backend.layout.template')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-12 text-start">
                        <div class="row">
                            <div class="col-3">
                                <div class="mb-3">
                                    <label class="form-label">Date Range</label>
                                    <input type="text" class="form-control date" id="singledaterange" data-toggle="date-picker" data-cancel-class="btn-warning">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="" class="form-label">Report Type</label>
                                    <select name="report_type" id="report_type" class="form-control">
                                        <option value="">All</option>
                                        <option value="location_wise">Location Wise</option>
                                        <option value="institute_wise">Institute Wise</option>
                                        <option value="class_wise">Class Wise</option>
                                        <option value="food_wise">Food Type</option>
                                        <option value="order_status">Order Status</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="" class="form-label">Sub Type</label>
                                    <select name="sub_type" id="sub_type" class="form-control">
                                        <option value="">All</option>
                                      
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 mt-3 pt-1">
                                <a href="javascript:void(0);" class="btn btn-primary mb-2" onclick="return search_report()" >
                                    Get Report</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap" id="reports-table">
                        <thead class="table-light">
                            <tr>
                                <th> Date </th>
                                <th> Register No </th>
                                <th> Location </th>
                                <th> Board </th>
                                <th> Class </th>
                                <th> Student </th>
                                <th> Order No </th>
                                <th> Amount </th>
                                <th> Food Type </th>
                                <th> Food </th>
                                <th> Order Status </th>
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
   
   var table = $('#reports-table').DataTable({
        processing: true,
        serverSide: true,
        type: 'GET',
        ajax: {
            url:  "{{ route('reports') }}",
            dataType: 'json',
            data: function (d) {
              d.range_date     = $('#singledaterange').val();
              d.report_type    = $('#report_type').val();
              d.sub_type = $('#sub_type').val();
            },
        },
        columns: [
            {data: 'date', name: 'date'},
            {data: 'register_no', name: 'register_no'},
            {data: 'location', name: 'location'},
            {data: 'board', name: 'board'},
            {data: 'class', name: 'class'},
            {data: 'student', name: 'student'},
            {data: 'order_no', name: 'order_no'},
            {data: 'total_price', name: 'amount'},
            {data: 'food_type', name: 'food_type'},
            {data: 'food', name: 'food'},
            {data: 'order_status', name: 'order_status', orderable: false, searchable: false},
        ],
        order: [],
    });

    $('#report_type').change(function(){
        var curr_value = $(this).val();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"{{ route('reports.getsubtype') }}",
            type: 'POST',
            data:{report_type:curr_value},
            beforeSend:function(){
                $('#sub_type').html('<option>fetching....</option>');
            },
            success:function(res){
                $('#sub_type').html(res);
            }
        });
    })

    function search_report() {
        table.ajax.reload();
    }

</script>
@endsection




                        

                    