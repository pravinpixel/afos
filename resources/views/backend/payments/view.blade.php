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
                        <tr><th>Payment Date</th><td>{{ $info->created_at ?? '' }}</td></tr>
                        <tr><th>Transaction No</th><td>{{ $info->transaction_no ?? '' }}</td></tr>
                        <tr><th>Order No</th><td>{{ $info->order->order_no ?? '' }}</td></tr>
                        <tr><th>Payee Name</th><td>{{ $info->order->payer_name ?? '' }}</td></tr>
                        <tr><th>Payee Contact No</th><td>{{ $info->order->payer_mobile_no ?? '' }}</td></tr>
                        <tr><th>Board</th><td>{{ $info->order->student->board ?? '' }}</td></tr>
                        <tr><th>Register No</th><td>{{ $info->register_no ?? '' }}</td></tr>
                    </table>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th colspan="2"> Payment Response</th>
                        </tr>
                        @if( isset( $info->response )  )
                            @php
                            $arr = unserialize( $info->response );
                            // dd( gettype($arr) );
                            @endphp
                            @if (is_array($arr) || is_object($arr))
                                @foreach ($arr as $key => $value)
                            
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>
                                            @php
                                                print_r( $value);
                                            @endphp
                                        
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="2">
                                    {{ $arr }}
                                </td>
                            </tr>
                            @endif
                            
                        
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

