<table class="table order-table">
    <thead>
        <tr>
            <th>Particular</th>
            <th></th>
            <th>Details</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Student Name</th>
            <td>:</td>
            <td>{{ $info->name ?? '' }}</td>
        </tr>
        <tr>
            <th>Register No</th>
            <td>:</td>
            <td>{{ $info->register_no ?? '' }}</td>
        </tr>
        <tr>
            <th>Class</th>
            <td>:</td>
            <td>{{ $info->standard ?? '' }}</td>
        </tr>
        <tr>
            <th>Section</th>
            <td>:</td>
            <td>{{ $info->section ?? '' }}</td>
        </tr>
        <tr>
            <th>Parents Name</th>
            <td>:</td>
            <td>{{ $info->parents_name ?? '' }}</td>
        </tr>
    </tbody>
</table>