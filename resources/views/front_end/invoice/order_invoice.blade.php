<!DOCTYPE html>
<html>
<body>
   <style>
       .header-table, .item-table {
        width: 100%; 
       }
        .header-table td,th {
           border: 1px solid #ddd;
           border-collapse: collapse;
           padding: 5px;
        }

        .item-table td,.item-table th {
           border: 1px solid #ddd;
           border-collapse: collapse;
           padding: 5px;
        }

        .no-border td, th {
            border:none;
            width: 100%;
            font-size: 13px;
            color: #000000;
        }
        .w-50 {
            width:50%;
        }
   </style>
    <table class="header-table" cellspacing="0" padding="0">
       <tr>
           
           <td colspan="2" style="text-align: center">
             <span><img src="{{ asset('assets/images/afos/logo.png') }}" alt="" height="100"></span> 
             <h2 style="margin-top: 17px;font-size: 20px;">Order Confirmation</h2>
            </td>
       </tr>
       <tr>
           <td>
               <table class="no-border" style="width: 100%">
                   <tr>
                       <td class="w-50"> Student name </td>
                       <td class="w-50"> {{ $info->order->student->name ?? '' }} </td>
                   </tr>
                   <tr>
                        <td class="w-50"> Student Register No </td>
                        <td class="w-50"> {{ $info->order->student->register_no ?? '' }} </td>
                    </tr>
                    <tr>
                        <td class="w-50"> Board </td>
                        <td class="w-50"> {{ $info->order->student->board ?? '' }} </td>
                    </tr>
                    <tr>
                        <td class="w-50"> Standard </td>
                        <td class="w-50"> {{ $info->order->student->standard ?? '' }} </td>
                    </tr>
                    <tr>
                        <td class="w-50"> Parents </td>
                        <td class="w-50">{{ $info->order->student->parents_name ?? '' }} </td>
                    </tr>
                    <tr>
                        <td class="w-50"> Contact No </td>
                        <td class="w-50">{{ $info->order->student->contact_no ?? '' }} </td>
                    </tr>
               </table>
           </td>
           <td>
                <table class="no-border" style="width: 100%">
                    <tr>
                        <td class="w-50"> Order No </td>
                        <td class="w-50">  {{ $info->order->order_no ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="w-50"> Payee Name </td>
                        <td class="w-50"> {{ $info->order->payer_name ?? '' }} </td>
                    </tr>
                    <tr>
                        <td class="w-50"> Payee Contact No </td>
                        <td class="w-50"> {{ $info->order->payer_mobile_no ?? '' }} </td>
                    </tr>
                    <tr>
                        <td class="w-50"> Date </td>
                        <td class="w-50">{{ date('d M Y h:i A', strtotime($info->order->created_at)) }} </td>
                    </tr>
                    <tr>
                        <td class="w-50"> Transaction No </td>
                        <td class="w-50">{{  $info->transaction_no }} </td>
                    </tr>
                    <tr>
                        <td class="w-50"> Payment Status </td>
                        <td class="w-50">{{ ucfirst($info->payment_status) }} </td>
                    </tr>
                </table>
           </td>
       </tr>
       
       
   </table>
   <table class="item-table" cellspacing="0" padding="0">
        <tr>
           <th style="width: 10px;">S.No</th>
           <th >Items</th>
           <th >Qty</th>
           <th>Price</th>
        </tr>
        @if( isset($info->order->items) && !empty($info->order->items))
        @php
            $i = 1;
        @endphp
            @foreach ($info->order->items as $item)
                <tr>
                    <td>{{ $i }}</td>
                    <td style="text-align: center">{{ $item->product->name }}</td>
                    <td style="text-align: center"> 1 </td>
                    <td style="text-align: right;padding:10px 20px;">{{ $item->price }}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
            <tr>
                <td colspan="2"></td>
                <td style="text-align: right;padding:0px 20px;font-weight:600"> Total</td>
                <td style="text-align: right;padding:10px 20px;font-weight:600"> {{ $info->order->total_price }} </td>
            </tr>
        @endif
   </table>
</body>
</html>