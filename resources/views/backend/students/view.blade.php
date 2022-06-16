<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="standard-modalLabel">{{ $title ?? '' }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
       
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-hover">
                        <tr><th>Name</th><td>{{ $info->name ?? '' }}</td></tr>
                        <tr><th>Institute</th><td>{{ $info->institute->name ?? '' }}</td></tr>
                        <tr><th>Board</th><td>{{ $info->board ?? '' }}</td></tr>
                        <tr><th>Register No</th><td>{{ $info->register_no ?? '' }}</td></tr>
                        <tr><th>Standard</th><td>{{ $info->standard ?? '' }}</td></tr>
                        <tr><th>Grade</th><td>{{ $info->section ?? '' }}</td></tr>
                        <tr><th>Parents/Guardians</th><td>{{ $info->parents_name ?? '' }}</td></tr>
                        <tr><th>Contact No</th><td>{{ $info->contact_no ?? '' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

