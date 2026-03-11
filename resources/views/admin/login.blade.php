<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="{{asset("assets/css/style.css")}}">
    <title>example Admin Panel</title>
    <!-- FAVICON -->
</head>

<body class="app sidebar-mini ltr login-img">

    <!-- BACKGROUND-IMAGE -->
    <div class="">

        <!-- PAGE -->
        <div class="page">
            <div class="">
                <!-- Theme-Layout -->

                <!-- CONTAINER OPEN -->
                <div class="col col-login mx-auto mt-7">
                    <div class="text-center">
                        <a href="/" ><img style="background: white;height:100px; padding: 5px; border-radius: 10px;" src="{{asset("assets/images/brand/logo.png")}}" class="header-brand-img" alt="logo" ></a>
                    </div>
                </div>

                <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" name="login_form" method="post" action="{{route("admin.authenticate")}}">
                            @csrf
                            <span class="login100-form-title pb-5">
                                Login
                            </span>
                            <div class="panel panel-primary">
                                <div class="panel-body tabs-menu-body p-0 pt-5">
                                    <div>
                                        @if (Session::has('success'))
                                            <p style="color: green;" class="text-center">{{ Session::get("success") }}</p>    
                                        @endif
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab5">
                                            <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                               
                                                <select name="type" id="type" class="form-control">
                                                    <option value="admin">Admin</option>
                                                    <option value="user">User</option>
                                                </select>
                                            </div>
                                            <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-account text-muted" aria-hidden="true"></i>
                                                </a>
                                                <input class="input100 border-start-0 form-control ms-0" value="{{old("username")}}" name='username' type="email" placeholder="Username">
                                            </div>
                                            @error('username')
                                                <p style="color: red;">{{ $message }}</p>    
                                            @enderror
                                            <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-key text-muted" aria-hidden="true"></i>
                                                </a>
                                                <input class="input100 border-start-0 form-control ms-0" name="password" type="password" placeholder="Password">
                                            </div>
                                            @error('password')
                                            <p style="color: red;">{{ $message }}</p>    
                                            @enderror
                                            
                                            <div class="container-login100-form-btn">
                                                <button type='submit' class="login100-form-btn btn-primary">
                                                        Login
                                                </button>
                                            </div>
                                                                                     
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!-- End PAGE -->

    </div>

</body>

</html>