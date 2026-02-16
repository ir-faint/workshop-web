    <!DOCTYPE html>
<html lang="en">
  {{-- head --}}
    @include('layouts.main.head')
  {{-- head:end --}}
  <body>
    @guest
        @yield('content')
    @else
    <div class="container-scroller">

        <!-- partial:partials/_navbar.html -->
        @include('layouts.main.navbar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('layouts.main.sidebar')
        <!-- partial -->

            <div class="main-panel">
                <div class="content-wrapper">
                    <main>            
                        @yield('content')
                    </main>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                    @include('layouts.main.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    @endguest
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('purple/assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
        {{-- <script src="assets/vendors/chart.js/chart.umd.js"></script>
        <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script> --}}
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('purple/assets/js/off-canvas.js')}}"></script>
    <script src="{{ asset('purple/assets/js/misc.js')}}"></script>
    <script src="{{ asset('purple/assets/js/settings.js')}}"></script>
    <script src="{{ asset('purple/assets/js/todolist.js')}}"></script>
    <script src="{{ asset('purple/assets/js/jquery.cookie.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    {{-- <script src="assets/js/dashboard.js"></script> --}}
    @stack('script')
    <!-- End custom js for this page -->
  </body>
</html>