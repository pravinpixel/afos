@extends('backend.layout.template')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-12 text-start">
                        <div class="row">
                            <div class="col-8">
                                <form id="importform" method="POST" action="{{ route('students.do.imports')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Select Import File</label>
                                                <input type="file" name="file" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-4 mt-3 pt-1">
                                            <button type="submit" id="loading" class="btn btn-primary mb-2">Import</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-4">
                                <label for=""> Sample Excel file </label>
                                <div class="mt-2">
                                    <a href="{{ asset('assets/data/sample-students.xls') }}" > <i class="mdi mdi-file h2"></i> Download Sample</a>
                                </div>
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
    $(document).ready(function(){
        $("#importform").validate({
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        $('#loading').html('Loading...');
                        $('#loading').attr('disabled', true);
                    },
                    success: function(response) {
                        $('#loading').html('Import');
                        $('#loading').attr('disabled', false);
                        console.log( response );
                        if( response.error == 0 ) {
                            toastr.success('Success', response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            toastr.error('Error', response.message);
                        }
                        
                    }            
                });		
                
            }
        });
    })
</script>
@endsection




                        

                    