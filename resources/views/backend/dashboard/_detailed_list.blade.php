<style>
    .summary {
        width:100%;
        border-collapse: collapse;
    }
    .summary th, td {
        padding: 5px;
        border: 1px solid black;
        
    }
    .item-head{
        font-size: 12px;
    }
    .item-count {
        text-align:center;
        font-size: 14px;
    }
</style>
<table class="summary">
    <thead>
        <tr>
            <th colspan="5">
                {{  $info->name ?? '' }} - {{ $food_category->categories ?? '' }} Manifest List
            </th>
        </tr>
        <tr>
           <th colspan="5">
                {{ date( 'D - d, M Y', strtotime($order_date)) }}
            </th>
        </tr>
        <tr>
           <th colspan="5">
                Total Order - {{ $total_order ?? 0 }}
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th> Reg.No </th>
            <th> Name </th>
            <th> Class </th>
            <th> {{ $food_category->categories ?? '' }} Food </th>
            <th> Issued (Tick) </th>
        </tr>

        @if (isset( $items ) && !empty($items))
            @foreach ($items as $item)
                <tr>
                    
                    <td class="item-count">{{ $item->register_no }}</td>
                    <td class="item-count">{{ $item->name }}</td>
                    <td class="item-count">{{ $item->standard }} - {{ $item->section }} </td>
                    <td class="item-count">{{ $item->product_name }}</td>
                    <td class="item-count"></td></td>
                    
                </tr> 
            @endforeach
        @endif
        
        <tr>
            <td colspan="5" style="text-align: center">
                (Printed on {{ date('d-m-Y h:i A') }})
            </td>
        </tr>
    </tbody>
</table>