<!DOCTYPE html>
<html>

<?php
    include("head.php");
?>
<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);"><b>RAGA</b> - Raj. Govt.</a>
            <small>Rajasthan Area Guide Application By Rizwan Syed</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" method="POST" action="includes/login_chk.php" name="login_form">
                    <div class="msg">Please Sign In to Continue...</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        
                        <div class="form-line">
                            <input type="text" class="form-control" name="log_email" placeholder="Email/Username" required autofocus>
                        </div>
                        
                    </div>

          
                                    
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line form-float">
                            <input type="password" class="form-control" name="log_password" placeholder="Password" onkeydown="if (event.keyCode == 13) {document.getElementById('user_login').click(); return false;}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-4">
                            <input class="btn btn-block bg-pink waves-effect" type="button" name="user_login" id="user_login" value="Login" onclick="return formhash(this.form,this.form.log_password)" onkeypress="return formhash(this.form,this.form.log_password)">
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <!--div class="col-xs-6">
                            <a href="sign-up.html">Register Now!</a>
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="forgot-password.html">Forgot Password?</a>
                        </div-->
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
    //include("jquery.php");
?>
</body>

</html>