<table class="table mb-5 order-table" >
    <tbody>
        
        @php
            $total = 0;
        @endphp
        @if (isset($items) && !empty($items))
            @foreach ($items as $item)
            @php
                $total += $item->price ?? 0;
            @endphp
            <tr>
                <td><img  width="80px" src="{{ asset('products/'.$item->image) }}" alt=""></td>
                <td>{{ $item->name }}</td>
                <td>Rs. {{ $item->price ?? 0 }}</td>
                <td>
                    <a href="javascript:void(0);" onclick="delete_food('{{ $item->id }}')">
                        <i class="fa fa-trash text-danger"></i>
                    </a>
                </td>
            </tr>
            @endforeach            
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="text-end">
                <b>Total</b>
            </td>
            <td><strong class="total">Rs {{ $total }}</strong></td>
            <td></td>
        </tr>
    </tfoot>
</table>