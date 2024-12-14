<div class="container">
    <div id="login-row" class="row">
        <div class="col-md-3">    </div>
        <div class="col-md-6">
            <div id="login-box" class="panel-body">
                <form id="login-form" class="form" action="" method="post">
                    <p style="color: red;"><?php print_r($userDetails); ?></p>
                    <h3 class="text-center text-info">Login</h3>
                    <div class="form-group">
                        <label for="username" class="text-info">Email Id:</label><br>
                        <input type="text" name="email" id="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password" class="text-info">Password:</label><br>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                    </div>
                    <div class="form-group text-right">
                        <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

