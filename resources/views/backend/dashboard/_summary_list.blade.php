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
            <th colspan="3">
                {{  $info->name ?? '' }} - {{ $food_category->categories ?? '' }} Manifesh List
            </th>
        </tr>
        <tr>
           <th colspan="3">
                {{ date( 'D - d, M Y', strtotime($order_date)) }}
            </th>
        </tr>
        <tr>
           <th colspan="3">
                Total Order - {{ $total_order ?? 0 }}
            </th>
        </tr>
    </thead>
    <tbody>

        @if (isset( $items ) && !empty($items))
            @foreach ($items as $item)
                <tr>
                    <th class="item-head">{{ $item->standard ?? ' ' }} {{ $item->section ?? ' ' }}</th>
                    <td class="item-count">{{ $item->item_count }}</td>
                    <td></td>
                </tr> 
            @endforeach
        @endif
        
        <tr>
            <td colspan="3" style="text-align: center">
                (Printed on {{ date('d-m-Y h:i A') }})
            </td>
        </tr>
    </tbody>
</table>