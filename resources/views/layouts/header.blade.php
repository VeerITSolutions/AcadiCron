<html class=" ">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Era International School</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="theme-color" content="#424242">
    <link href="https://erp.erabesa.co.in/uploads/school_content/admin_small_logo/1.png" rel="shortcut icon"
        type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('public/backend/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/dist/css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/dist/themes/white/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/dist/themes/white/ss-main.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/dist/css/main.css') }}">


    <link rel="stylesheet" href="{{ asset('public/backend/dist/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/dist/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/iCheck/flat/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/morris/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/colorpicker/bootstrap-colorpicker.css') }}">

    <link rel="stylesheet" href="{{ asset('public/backend/plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <link rel="stylesheet"
        href="{{ asset('public/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

    <link rel="stylesheet" href="{{ asset('public/backend/dist/css/custom_style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/datepicker/css/bootstrap-datetimepicker.css') }}">
    <!--file dropify-->
    <link rel="stylesheet" href="{{ asset('public/backend/dist/css/dropify.min.css') }}">
    <!--file nprogress-->
    <link href="{{ asset('public/backend/dist/css/nprogress.css') }}" rel="stylesheet">

    <!--print table-->
    <link href="{{ asset('public/backend/dist/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/backend/dist/datatables/css/buttons.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/backend/dist/datatables/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <!--print table mobile support-->
    <link href="{{ asset('public/backend/dist/datatables/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/backend/dist/datatables/css/rowReorder.dataTables.min.css') }}" rel="stylesheet">
    <!--language css-->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/backend/dist/css/bootstrap-select.min.css') }}">
    <script src="{{ asset('public/backend/custom/jquery.min.js') }}"></script>
    <script src="{{ asset('public/backend/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/backend/datepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/colorpicker/bootstrap-colorpicker.js') }}"></script>
    <script src="{{ asset('public/backend/datepicker/date.js') }}"></script>
    <script src="{{ asset('public/backend/dist/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/backend/js/school-custom.js') }}"></script>
    <script src="{{ asset('public/backend/js/school-admin-custom.js') }}"></script>
    <script src="{{ asset('public/backend/js/sstoast.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('public/backend/fullcalendar/dist/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/fullcalendar/dist/fullcalendar.print.min.css') }} ">
    <script type="text/javascript">
        var baseurl = @json(url());
        var start_week = 1;
        var chk_validate = "QBP5VG-U2TW26-E44VDK-dHRORjJDR0xyS2szd2JUTkVUaW1Bbm9kc1c2QjVHdWZvdlUvNDVObFNxcz0=";
    </script>

    <style type="text/css">
        span.flag-icon.flag-icon-us {
            text-orientation: mixed;
        }
    </style>
</head>

<body class="skin-blue fixed sidebar-mini">



    <script>
        function collapseSidebar() {

            if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
                sessionStorage.setItem('sidebar-toggle-collapsed', '');
            } else {
                sessionStorage.setItem('sidebar-toggle-collapsed', '1');
            }

        }

        function checksidebar() {
            if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
                var body = document.getElementsByTagName('body')[0];
                body.className = body.className + ' sidebar-collapse';
            }
        }

        checksidebar();
    </script>

    <div class="wrapper">
