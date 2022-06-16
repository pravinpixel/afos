<!DOCTYPE html>
    <html lang="en">

   @include('backend.layout.header')

    <body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            @include('backend.layout.left_menu')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    @include('backend.layout.top_bar')
                    <!-- end Topbar -->
                    
                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            @include('backend.layout.parts.breadcrum')
                        </div>
                        <!-- end page title -->

                       @yield('content')
                        
                    </div>
                    <!-- container -->

                </div>
                <!-- content -->

               

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <div class="rightbar-overlay"></div>
        <!-- /End-bar -->

        <!-- bundle -->
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.min.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="{{ asset('assets/js/vendor/sweetalert.min.js') }}"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        

        @yield('third_party_js')
        @yield('add_on_script')
        @yield('add_on_script1')
        @yield('add_on_script2')
        @include('backend.layout.parts._modal')
       <script>
           $(document).on("input", ".price", function() {
        this.value = this.value.match(/^\d+\.?\d{0,2}/);});
       </script>
    </body>
</html>