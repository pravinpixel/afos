@extends('backend.layout.template')
@section('content')
<style>
    #loader{
        top: 51%;
        position: absolute;
        width: 50px;
        height: 50px;
        border: 2px solid rgba(255,255,255,0.2);
        border-radius: 50px;
        left:50%;
        margin-left: -25px;
        animation-name: spinner 0.4s linear infinite;
        -webkit-animation: spinner 0.4s linear  infinite;
        -moz-animation: spinner 0.4s linear  infinite; 
    }
        #loader:before{
            position: absolute;
            content:'';
            display: block;
            background-color: rgba(0,0,0,0.2);
            width: 80px;
            height: 80px;
            border-radius: 80px;
            top: -15px;
            left: -15px;
            }
        #loader:after{
            position: absolute;
            content:'';
            width: 50px;
            height: 50px;
            border-radius: 50px;
            border-top:2px solid white;
            border-bottom:2px solid white;
            border-left:2px solid white;
            border-right:2px solid transparent;
            top: -2px;
            left: -2px;
            }
        
        @keyframes spinner{
            from {transform: rotate(0deg);}
            to {transform: rotate(360deg);}
            }

        @-webkit-keyframes spinner{
            from {transform: rotate(0deg);}
            to {transform: rotate(360deg);}
            }

        @-moz-keyframes spinner{
            from {transform: rotate(0deg);}
            to {transform: rotate(360deg);}
            }



</style>
<div class="row">
    <div class="col-xl-8 col-lg-8">
        <style>
            .card.col-lg-12.p-2.table-responsive::-webkit-scrollbar {
                height: 2px;
                background:#ddd
            }

            .card.col-lg-12.p-2.table-responsive::track {
                background:#2691cd
            }

            .card.col-lg-12.p-2.table-responsive::thumb {
                background:rgb(167, 160, 160)
            }

            table th {
                background: linear-gradient(350deg, #289BD5, #133C8E);
                color: #fff;
            }
        </style>
        <div class="row">
            @if( isset($school) && !empty($school) )
                @foreach ($school as $item)
                    <div class="col-lg-6">
                        <div class="card widget-flat">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class="mdi mdi-account-multiple widget-icon"></i>
                                </div>
                                <h5 class="text-muted fw-normal mt-0" title="Number of Customers">{{ $item->name }} Students</h5>
                                <h3 class="mt-3 mb-3">{{ $item->students_count }}</h3>
                                
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                @endforeach
            @endif

            <div class="col-lg-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-cart-plus widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Orders</h5>
                        <h3 class="mt-3 mb-3">{{ $order_count ?? 0 }}</h3>
                       
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col-lg-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-currency-usd widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Average Revenue">Revenue</h5>
                        <h3 class="mt-3 mb-3">INR {{ $revenue ?? 0 }}</h3>
                        
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row -->
        <div class="row">
   

            <div class="col-xl-12 col-lg-12 order-lg-2">
                <div class="card">
                    <div class="card-body">
                       
                        <h4 class="header-title">Total Sales</h4>
                        @php
                            $colors = array( '#727cf5', '#0acf97', '#fa5c7c', '#ffbc00');
                        @endphp
                        
                        <div id="average-sales" class="apex-charts mb-4 mt-4" data-colors="#727cf5,#0acf97,#fa5c7c,#ffbc00"></div>
                        @php
                            $categ = [];
                            $amnt = [];
                        @endphp
                        <div class="chart-widget-list">
                            @if( isset($category) && !empty($category))
                                @foreach ($category as $key => $item)
                                    @php
                                    
                                        $categ[] = $item->categories; 
                                        $amnt[] = (int)$item->total_sales; 
                                    @endphp
                                    <p>
                                        <i class="mdi mdi-square" style="color:{{ $colors[$key] }}"></i> {{ $item->categories }}
                                        <span class="float-end">INR {{ $item->total_sales }}</span>
                                    </p>
                                @endforeach                   
                            @endif
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
            <!-- end col -->
        </div>

    </div> <!-- end col -->
    <div class="col-xl-4 col-lg-4" style="position: relative">
        <div class="row card p-2">
            <div class="col-lg-12 p-2">
                <div class="row">
                    <div class="col-md-7">
                        <h3>Daily Manifest</h3>
                    </div>
                    
                </div> 
            </div>
            <div class="col-lg-12 card">
                <div class="row p-2 pt-3">
                    <div class="col-md-6">
                        <select name="category" id="category" class="form-control" onchange="return get_orders_count()">
                            <option value="">All</option>
                            @if (isset($food_category) && !empty($food_category))
                                @foreach ($food_category as $item)
                                    <option value="{{ $item->id }}">{{ $item->categories ?? '' }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="date" name="order_date" onchange="return get_orders_count()" id="order_date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div> 
                <div class="row ">
                    <div class="col-lg-12 text-center">
                        <h3>Orders</h3>
                    </div>
                    @if( isset($todayschool) && !empty($todayschool) ) 
                        @foreach ($todayschool as $item)
                            <div class="col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <div class="text-end">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-info" onclick="return download_order_list('{{ $item->id }}', 'summary')"><i class="mdi mdi-briefcase-download"></i> Summary List</a>
                                            </div>
                                            <div class="mt-3 text-end">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="return download_order_list('{{ $item->id }}', 'detailed')"><i class="mdi mdi-briefcase-download"></i> Details List</a>
                                            </div>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Orders" id="ins_{{ $item->id }}">{{ $item->name }}</h5>
                                        <h3 class="mt-3 mb-3" id="count_{{ $item->id }}">{{ get_order_item_count($item->id, date('Y-m-d'))->count() ?? 0 }}</h3>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
                        @endforeach
                    @endif
                </div>
            </div> <!-- end col-->
            
        </div>
        <div id="loader" style="display: none"></div>
    </div>
</div>
<!-- end row -->

<!-- end row -->

<!-- end row -->
@endsection
@section('third_party_js')
<script>
    var average_sale_labels = '{!! json_encode($categ) !!}';
    // average_sale_labels = JSON.parse(average_sale_labels);
    var average_sale_values = '{!! json_encode($amnt) !!}';
    average_sale_labels = JSON.parse(average_sale_labels);
    average_sale_values = JSON.parse(average_sale_values);
</script>
    <!-- third party js -->
    <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- third party js ends -->
    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/demo.dashboard.js') }}"></script>

    <script>

        function get_orders_count() {
            var category =$('#category').val();
            var order_date = $('#order_date').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('get_orders_count') }}",
                data:  {order_date:order_date, category:category},
                beforeSend:function() {
                    $('#loader').show();
                },
                success: function(response){
                    
                    if( response ) {
                        $('#loader').hide();
                        for (let index = 0; index < response.length; index++) {
                            $('#count_'+response[index]['id']).html(response[index]['count']);
                        }
                    }
                    
                },
            });
        }
        function download_order_list(institute_id, download_type) {
            var order_date = $('#order_date').val();
            var category = $('#category').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('download_list') }}",
                data:  {order_date:order_date,institute_id:institute_id, download_type:download_type, category:category},
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response){
                    
                    var blob = new Blob([response]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = download_type+".pdf";
                    link.click();
                },
                error: function(blob){
                    console.log(blob);
                }
            });
        }
    </script>
    <!-- end demo js-->
@endsection
