@extends('backend.layout.template')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-12 text-start">
                        <div class="row">
                           
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="" class="form-label">School</label>
                                    <select name="report_type" id="report_type" class="form-control">
                                        <option value="">All</option>
                                        @if (isset( $school ) && !empty($school))
                                            @foreach ($school as $item)
                                                <option value="{{ $item->id }}">{{ $item->name  }} ( {{ $item->institute_code }} ) </option>
                                            @endforeach
                                        @endif
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="" class="form-label">Class</label>
                                    <select name="class" id="class" class="form-control">
                                        <option value="">All</option>
                                        @if (isset( $food_category ) && !empty($food_category))
                                            @foreach ($food_category as $item)
                                                <option value="{{ $item->id }}">{{ $item->categories  }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="" class="form-label">Food Type</label>
                                    <select name="food_type" id="food_type" class="form-control">
                                        <option value="">All</option>
                                        @if (isset( $food_category ) && !empty($food_category))
                                        @foreach ($food_category as $item)
                                            <option value="{{ $item->id }}">{{ $item->categories  }}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 mt-3 pt-1">
                                <a href="javascript:void(0);" class="btn btn-primary mb-2" onclick="return search_report()" >
                                    Get Report</a>
                                @if (check_user_access('reports', 'editable'))
                                    <a href="javascript:void(0);" class="btn btn-info mb-2" onclick="return downloadExcel()" >
                                    Export Report</a>
                                @endif
                            </div>
                        </div>
                    </div>
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

    function downloadExcel() {

        var range_date      = $('#singledaterange').val();
        var report_type     = $('#report_type').val();
        var sub_type        = $('#sub_type').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            xhrFields: {
                responseType: 'blob',
            },
            type: 'POST',
            url: "{{ route('reports.download') }}",
            data: {
                range_date: range_date,
                report_type: report_type,
                sub_type: sub_type,
            },
            success: function(result, status, xhr) {
                var disposition = xhr.getResponseHeader('content-disposition');
                var matches = /"([^"]*)"/.exec(disposition);
                var filename = (matches != null && matches[1] ? matches[1] : 'reports.xlsx');
                // The actual download
                var blob = new Blob([result], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        });
    }

</script>
@endsection




                        

                    