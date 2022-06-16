<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="standard-modalLabel">{{ $title ?? '' }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
       
        <div class="modal-body">
            <div class="row">
                <div class="col-12 text-end">
                    <a target="_blank" href="{{ asset('storage/invoice_order/'.$info->order_no.'.pdf' ) }}">Download Order</a>
                </div>
                <div class="col-12">
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
                             </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="no-border" style="width: 100%">
                                    <tr>
                                        <td class="w-50"> Student name </td>
                                        <td class="w-50"> {{ $info->student->name ?? '' }} </td>
                                    </tr>
                                    <tr>
                                         <td class="w-50"> Student Register No </td>
                                         <td class="w-50"> {{ $info->student->register_no ?? '' }} </td>
                                     </tr>
                                     <tr>
                                         <td class="w-50"> Board </td>
                                         <td class="w-50"> {{ $info->student->board ?? '' }} </td>
                                     </tr>
                                     <tr>
                                         <td class="w-50"> Standard </td>
                                         <td class="w-50"> {{ $info->student->standard ?? '' }} </td>
                                     </tr>
                                     <tr>
                                         <td class="w-50"> Parents </td>
                                         <td class="w-50">{{ $info->student->parents_name ?? '' }} </td>
                                     </tr>
                                     <tr>
                                         <td class="w-50"> Contact No </td>
                                         <td class="w-50">{{ $info->student->contact_no ?? '' }} </td>
                                     </tr>
                                </table>
                            </td>
                            <td>
                                 <table class="no-border" style="width: 100%">
                                     <tr>
                                         <td class="w-50"> Order No </td>
                                         <td class="w-50">  {{ $info->order_no ?? '' }}</td>
                                     </tr>
                                     <tr>
                                         <td class="w-50"> Payee Name </td>
                                         <td class="w-50"> {{ $info->payer_name ?? '' }} </td>
                                     </tr>
                                     <tr>
                                         <td class="w-50"> Payee Contact No </td>
                                         <td class="w-50"> {{ $info->payer_mobile_no ?? '' }} </td>
                                     </tr>
                                     <tr>
                                         <td class="w-50"> Date </td>
                                         <td class="w-50">{{ date('d M Y h:i A', strtotime($info->created_at)) }} </td>
                                     </tr>
                                     <tr>
                                         <td class="w-50"> Transaction No </td>
                                         <td class="w-50">{{  $info->payment->transaction_no }} </td>
                                     </tr>
                                     <tr>
                                         
                                         <td class="w-50"> Payment Status </td>
                                         <td class="w-50">{{ ucfirst($info->payment->payment_status) }} </td>
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
                         @if( isset($info->items) && !empty($info->items))
                         @php
                             $i = 1;
                         @endphp
                             @foreach ($info->items as $item)
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
                                 <td style="text-align: right;padding:10px 20px;font-weight:600"> {{ $info->total_price }} </td>
                             </tr>
                         @endif
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

