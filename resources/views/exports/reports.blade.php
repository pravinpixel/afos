<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Order No</th>
            <th>Student Name</th>
            <th>Food</th>
            <th>Food category</th>
            <th>Price</th>
            <th>Location</th>
            <th>Register No</th>
            <th>Board</th>
            <th>Class</th>
            <th>Total price</th>
            <th>Payer Name</th>
            <th>Payer Mobile Number</th>
        </tr>
    </thead>
    <tbody>
        @if( isset( $list ) && !empty($list))
            @foreach ($list as $item)
            <tr>
                <td>{{ $item->date }}</td>
                <td>{{ $item->order_no }}</td>
                <td>{{  $item->student }}</td>
                <td>{{ $item->product_name }}</td>
                <td> {{ $item->food_type }} </td>
                <td> {{ $item->product_price }} </td>
                <td> {{ $item->location }} </td>
                <td> {{ $item->register_no }} </td>
                <td> {{ $item->board }} </td>
                <td> {{ $item->class }} </td>
                <td> {{ $item->total_price }} </td>
                <td> {{ $item->payer_name }} </td>
                <td> {{ $item->payer_mobile_no }} </td>
                
            </tr>
            @endforeach
        @endif
        
    </tbody>
    
</table>