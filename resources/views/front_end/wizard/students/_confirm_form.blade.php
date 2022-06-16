<form action="{{ route('order.student.initialize') }}"  method="POST" id="initialize_form" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <input type="button" id="confirm" value="Confirm" class="w-100 btn btn-primary">
</form>