<form id="student_form" method="POST" action="{{ route('check.student')}}" enctype="multipart/form-data">
    @csrf
    <div class="my-3 mb-4">
        <h5>Choose the school</h5>
        @if( isset($institution) && !empty($institution))
            @foreach ($institution as $item)
                <label for="{{ $item->institute_code }}" class="check-box">
                    <div>
                        <input type="radio" name="institute" value="{{ $item->id }}"  class="form-check-input" id="{{ $item->institute_code }}" >
                    </div>
                    <span>{{ $item->name }} ({{ $item->institute_code }})</span>
                </label>
            @endforeach
        @endif
    </div>
    <div class="my-3">
        <h5>Enter Student Details</h5>
        <div class="row">
            <div class="col-md-6 my-2">
                <span>Register Number / Application Number</span>
            </div>
            <div class="col-md-6 my-2">
                <input type="text" class="numberonly form-control" name="register_no" id="register_no" placeholder="Type here ..." >
            </div>
            <div class="col-md-6 my-2">
                <span>Date Of Birth</span>
            </div>
            <div class="col-md-6 my-2">
                <input type="date" name="dob" id="dob" class="form-control">
            </div>
        </div> 
    </div>
    <input type="button" value="Submit" id="save"class="w-100 btn btn-primary">
    <div class="text-center mt-3">
        <strong class="text-danger " id="error_msg"></strong>
    </div>
</form>
<script>
    $('#register_no').keyup(function(){
        var cur = $(this).val();
        if( $(this).hasClass('error') ) {
            if( cur.length > 0 ) {
                $('#register_no').removeClass('error');
            }
        }
    })

    $("#student_form input[type='radio']").change(function() {
        $('.option_card label').css('border', '1px solid #289BD5');
    });

    $('#dob').change(function(){
        var cur = $(this).val();
        if( cur != undefined && cur != null && cur != '') {
            $('#dob').removeClass('error');
        }
    })

    $(document).ready(function(){
        $("#save").click(function() {

            var inst = $("#student_form input[type='radio']:checked").val();
            var register_no = $('#register_no').val();
            var dob = $('#dob').val();
            var error = '';
            if( inst == undefined ){
                $('.option_card label').css('border', '1px solid red');
                error = true;
            } else {
                $('.option_card label').css('border', '1px solid #289BD5');
            }
            
            if( register_no == undefined || register_no == '' || register_no == null ){
                $('#register_no').addClass('error');
                error = true;
            } else {
                $('#register_no').removeClass('error');
            }

            if( dob == undefined || dob == '' || dob == null ){
                $('#dob').addClass('error');
                error = true;
            } else {
                $('#dob').removeClass('error');
            }
            if( error ) {
                return false;
            }
            
            var form = $('#student_form')[0]
            var formData = new FormData(form);
            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    $('#save').attr('disabled', true);
                    $('#loading').show();
                },
                success: function(response) {
                    $('#loading').hide();

                    $('#save').attr('disabled', false);
                    console.log( response );
                    if( response.error == 0 ) {
                        if( response.id ){
                            student_info(response.id);
                        }
                    } else {
                        $('#error_msg').show();
                        $('#error_msg').html('Student details not found');
                        $('#error_msg').fadeOut(5000);
                    }
                    
                }            
            });		
            
        });
    })

    function student_info(student_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                url: "{{ route('student.list') }}",
                type: 'POST',
                data: {student_id:student_id},
                success: function(response) {
                    $('#step1').html(response);
                }            
            });
    }
</script>