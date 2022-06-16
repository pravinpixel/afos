@extends('backend.layout.template')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">

        <div class="row">
            @if( isset($school) && !empty($school) )
                @foreach ($school as $item)
                    <div class="col-lg-3">
                        <div class="card widget-flat">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class="mdi mdi-account-multiple widget-icon"></i>
                                </div>
                                <h5 class="text-muted fw-normal mt-0" title="Number of Customers">{{ $item->name }} Students</h5>
                                <h3 class="mt-3 mb-3">{{ $item->students_count }}</h3>
                                {{-- <p class="mb-0 text-muted">
                                    <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                                    <span class="text-nowrap">Since last month</span>  
                                </p> --}}
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                @endforeach
            @endif

            <div class="col-lg-3">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="mdi mdi-cart-plus widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Orders</h5>
                        <h3 class="mt-3 mb-3">{{ $order_count ?? 0 }}</h3>
                        {{-- <p class="mb-0 text-muted">
                            <span class="text-danger me-2"><i class="mdi mdi-arrow-down-bold"></i> 1.08%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p> --}}
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col-lg-3">
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

    </div> <!-- end col -->

</div>
<!-- end row -->


<!-- end row -->


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
    <!-- end demo js-->
@endsection
