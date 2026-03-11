<!doctype html>
<html lang="en" dir="ltr">

<head>
    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Proven Tech">
    <meta name="author" content="Proven Tech">
    <link rel="stylesheet" href="">
    <link id="style" href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    @yield("title")
    <!-- STYLE CSS -->
    <link href="{{asset("assets/css/style.css")}}" rel="stylesheet">

    <!-- Plugins CSS -->
    <link href="{{asset("assets/css/plugins.css")}}" rel="stylesheet">

    <!--- FONT-ICONS CSS -->
    <link href="{{asset("assets/css/icons.css")}}" rel="stylesheet">

    <!-- INTERNAL Switcher css -->
    <link href="{{asset("assets/switcher/css/switcher.css")}}" rel="stylesheet">
    <link href="{{asset("assets/switcher/demo.css")}}" rel="stylesheet">

    <!-- JQUERY JS -->
    <script src="{{asset("assets/js/jquery.min.js")}}"></script>

    <!-- BOOTSTRAP JS -->
    <script src="{{asset("assets/plugins/bootstrap/js/popper.min.js")}}"></script>
    <script src="{{asset("assets/plugins/bootstrap/js/bootstrap.min.js")}}"></script>

    <!-- Old Files -->
    <link rel="stylesheet" type="text/css" href="{{asset("assets/font-awesome-v5/css/all.min.css")}}" />
    <script type="text/javascript" src="{{asset("assets/font-awesome-v5/js/all.min.js")}}"></script>
    <script type="text/javascript" src="{{asset("assets/js/notify.min.js")}}"></script>

    <script SRC="{{asset("assets/tinymce/tinymce.min.js")}}"></script>
    <script SRC="{{asset("assets/js/editor.js")}}"></script>
    <link REL="STYLESHEET" HREF="{{asset("assets/css/chosen.css")}}" />
    <script TYPE="TEXT/JAVASCRIPT" SRC="{{asset("assets/js/chosen.js")}}"></script>
    <script TYPE="TEXT/JAVASCRIPT" SRC="{{asset("assets/js/custom1.js")}}"></script>
    <link href="{{asset("assets/select/css/select2.min.css")}}" rel="stylesheet" />
    <script src="{{asset("assets/select/js/select2.min.js")}}"></script>
    <script src="{{asset("assets/js/select2.js")}}"></script>

    <style>
        .select2-container{
            
            
            border: none;
        }
        .select2-container--default .select2-selection--single {
        
        border: none;
        border-radius: 3px;
    }
    </style>

    <script>

        $(document).ready(function(){
        
            $(".chosen").chosen({
        
                disable_search_threshold: 10,
        
                no_results_text: "No record found!"
        
            });
        
        });
    
        $(document).ready(function() {
            $('.select-search').select2();
        });
    
    </script>
    
    <script>
        $(window).bind("load", function(){
            @if (Session::has('success'))
                $.notify("{{ Session::get("success") }}", { className: 'success', autoHide: true, autoHideDelay: 8000 });
            @endif
            @if (Session::has('error'))
                $.notify("{{ Session::get("error") }}", { className: 'error', autoHide: true, autoHideDelay: 8000 });
            @endif
        });
    </script>
    @yield('styles')
    <!-- FAVICON -->
</head>

<body class="app sidebar-mini ltr light-mode">
    <!-- PAGE -->
    <div class="page">
        <div class="page-main">

            @include("admin.layout.header")
            <!--app-content open-->
            <div class="main-content app-content mt-0">
                <div class="side-app">

                    <!-- CONTAINER -->
                    @yield("content")
                    <!-- CONTAINER END -->
                </div>
            </div>
            <!--app-content close-->

        </div>

      

        <!-- FOOTER -->
        @include("admin.layout.footer");
        <!-- FOOTER END -->


    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
     

    <!-- SPARKLINE JS-->
    <script src="{{asset("assets/js/jquery.sparkline.min.js")}}"></script>

    <!-- Sticky js -->
    <script src="{{asset("assets/js/sticky.js")}}"></script>

    <!-- CHART-CIRCLE JS-->
    <script src="{{asset("assets/js/circle-progress.min.js")}}"></script>

    <!-- PIETY CHART JS-->
    <script src="{{asset("assets/plugins/peitychart/jquery.peity.min.js")}}"></script>
    <script src="{{asset("assets/plugins/peitychart/peitychart.init.js")}}"></script>

    <!-- SIDEBAR JS -->
    <script src="{{asset("assets/plugins/sidebar/sidebar.js")}}"></script>

    <!-- Perfect SCROLLBAR JS-->
    <script src="{{asset("assets/plugins/p-scroll/perfect-scrollbar.js")}}"></script>
    <script src="{{asset("assets/plugins/p-scroll/pscroll.js")}}"></script>
    <script src="{{asset("assets/plugins/p-scroll/pscroll-1.js")}}"></script>

    <!-- INTERNAL CHARTJS CHART JS-->
    <script src="{{asset("assets/plugins/chart/Chart.bundle.js")}}"></script>
    <script src="{{asset("assets/plugins/chart/utils.js")}}"></script>

    <!-- INTERNAL SELECT2 JS -->
    <script src="{{asset("assets/plugins/select2/select2.full.min.js")}}"></script>

    <!-- INTERNAL Data tables js-->
    <!-- DATA TABLE JS-->
    <script src="{{asset("assets/plugins/datatable/js/jquery.dataTables.min.js")}}"></script>
    <script src="{{asset("assets/plugins/datatable/js/dataTables.bootstrap5.js")}}"></script>
    <script src="{{asset("assets/plugins/datatable/js/dataTables.buttons.min.js")}}"></script>
    <script src="{{asset("assets/plugins/datatable/js/buttons.bootstrap5.min.js")}}"></script>
    <script src="{{asset("assets/plugins/datatable/js/jszip.min.js")}}"></script>
    <script src="{{asset("assets/plugins/datatable/pdfmake/pdfmake.min.js")}}"></script>
    <script src="{{asset("assets/plugins/datatable/pdfmake/vfs_fonts.js")}}"></script>
    <script src="{{asset("assets/plugins/datatable/js/buttons.html5.min.js")}}"></script>
    <script src="{{asset("assets/plugins/datatable/js/buttons.print.min.js")}}"></script>
    <script src="{{asset("assets/plugins/datatable/js/buttons.colVis.min.js")}}"></script>
    <script src="{{asset("assets/plugins/datatable/dataTables.responsive.min.js")}}"></script>
    <script src="{{asset("assets/plugins/datatable/responsive.bootstrap5.min.js")}}"></script>
    <script src="{{asset("assets/js/table-data.js")}}"></script>


    <!-- INTERNAL APEXCHART JS -->
    <script src="{{asset("assets/js/apexcharts.js")}}"></script>
    <script src="{{asset("assets/plugins/apexchart/irregular-data-series.js")}}"></script>

    <!-- INTERNAL Flot JS -->
    <script src="{{asset("assets/plugins/flot/jquery.flot.js")}}"></script>
    <script src="{{asset("assets/plugins/flot/jquery.flot.fillbetween.js")}}"></script>
    <script src="{{asset("assets/plugins/flot/chart.flot.sampledata.js")}}"></script>
    <script src="{{asset("assets/plugins/flot/dashboard.sampledata.js")}}"></script>

    <!-- INTERNAL Vector js -->
    <script src="{{asset("assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js")}}"></script>
    <script src="{{asset("assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js")}}"></script>

    <!-- SIDE-MENU JS-->
    <script src="{{asset("assets/plugins/sidemenu/sidemenu.js")}}"></script>

    <!-- TypeHead js -->
    <script src="{{asset("assets/plugins/bootstrap5-typehead/autocomplete.js")}}"></script>
    <script src="{{asset("assets/js/typehead.js")}}"></script>

    <!-- INTERNAL INDEX JS -->
    <script src="{{asset("assets/js/index1.js")}}"></script>

    <!-- Color Theme js -->
    <script src="{{asset("assets/js/themeColors.js")}}"></script>

    <!-- CUSTOM JS -->
    <script src="{{asset("assets/js/custom.js")}}"></script>

    <!-- Custom-switcher -->
    <script src="{{asset("assets/js/custom-swicher.js")}}"></script>

    <!-- Switcher js -->
    <script src="{{asset("assets/switcher/js/switcher.js")}}"></script>


   <script>
       function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>

</body>

</html>
