<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#424242">
    <title>Login : Era International School</title>
    <link href="https://erp.erabesa.co.in/uploads/school_content/admin_small_logo/1.png" rel="shortcut icon"
        type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="https://erp.erabesa.co.in/backend/usertemplate/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://erp.erabesa.co.in/backend/usertemplate/assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://erp.erabesa.co.in/backend/usertemplate/assets/css/form-elements.css">
    <link rel="stylesheet" href="https://erp.erabesa.co.in/backend/usertemplate/assets/css/style.css">
    <link rel="stylesheet"
        href="https://erp.erabesa.co.in/backend/usertemplate/assets/css/jquery.mCustomScrollbar.min.css">
    <style type="text/css">
        body {
            background: linear-gradient(to right, #676767 0, #dadada 100%);
        }

        /*.loginbg {background: #455a64;}*/
        .top-content {
            position: relative;
        }

        .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {
            background: rgb(53, 170, 71);
        }

        .bgoffsetbgno {
            background: transparent;
            border-right: 0 !important;
            box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.29);
            border-radius: 4px;
        }

        .loginradius {
            border-radius: 4px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
</head>

<body>
    <!-- Top content -->
    <div class="top-content">

        <div class="inner-bg">

            <div class="container">
                <div class="row">
                    <div class="">

                        <div class="col-lg-4 col-md-4 col-sm-12 nopadding bgoffsetbgno col-md-offset-4">
                            <div class="loginbg loginradius login390">
                                <div class="form-top">
                                    <div class="form-top-left logowidth">
                                        <img src="https://erp.erabesa.co.in/uploads/school_content/admin_logo/1.png">
                                    </div>
                                </div>


                                <div class="form-bottom">
                                    <h3 class="font-white">User Login</h3>
                                    <form action="{{ route('login') }}" method="post">

                                        @csrf

                                        <input type="hidden" name="ci_csrf_token" value="">
                                        <div class="form-group has-feedback">
                                            <label class="sr-only" for="form-username">
                                                Username</label>
                                            <input type="text" name="username" value="" placeholder="Username"
                                                class="form-username form-control" id="email">
                                            <span class="fa fa-envelope form-control-feedback"></span>
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="password" name="password" value="" placeholder="Password"
                                                class="form-password form-control" id="password">
                                            <span class="fa fa-lock form-control-feedback"></span>
                                            <span class="text-danger"></span>
                                        </div>
                                        <button type="submit" class="btn">
                                            Sign In</button>
                                    </form>

                                    <p><a href="https://erp.erabesa.co.in/site/ufpassword" class="forgot"> <i
                                                class="fa fa-key"></i> Forgot Password</a> </p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://erp.erabesa.co.in/backend/usertemplate/assets/js/jquery-1.11.1.min.js"></script>
    <script src="https://erp.erabesa.co.in/backend/usertemplate/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://erp.erabesa.co.in/backend/usertemplate/assets/js/jquery.backstretch.min.js"></script>
    <script src="https://erp.erabesa.co.in/backend/usertemplate/assets/js/jquery.mCustomScrollbar.min.js"></script>
    <script src="https://erp.erabesa.co.in/backend/usertemplate/assets/js/jquery.mousewheel.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on(
                'focus',
                function() {
                    $(this).removeClass('input-error');
                });
            $('.login-form').on('submit', function(e) {
                $(this).find('input[type="text"], input[type="password"], textarea').each(function() {
                    if ($(this).val() == "") {
                        e.preventDefault();
                        $(this).addClass('input-error');
                    } else {
                        $(this).removeClass('input-error');
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        function refreshCaptcha() {
            $.ajax({
                type: "POST",
                url: "https://erp.erabesa.co.in/site/refreshCaptcha",
                data: {},
                success: function(captcha) {
                    $("#captcha_image").html(captcha);
                }
            });
        }
    </script>
</body>

</html>
