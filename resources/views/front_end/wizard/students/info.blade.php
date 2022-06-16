<div>

    <div class="card-title">
        Student Info
    </div>
    @include('front_end.wizard.common._student_info')
    <div id="bottom_action_student">
        @if(session()->get('order') )
            @include('front_end.wizard.students._bottom_pane')
        @else
            @include('front_end.wizard.students._confirm_form')
        @endif
        
    </div>
    
</div>
<script>
    $("#confirm").click(function() {

        var form = $('#initialize_form')[0]
        var formData = new FormData(form);
        $.ajax({
            url: form.action,
            type: form.method,
            data: formData,
            contentType: false,
            processData: false,
            beforeSend:function(){
                $('#loading').show();
            },
            success: function(response) {
                if( response ){
                    $('#loading').hide();
                    window.location.href="{{ route('online.food') }}";
                }
            }            
        });		

    });
</script>