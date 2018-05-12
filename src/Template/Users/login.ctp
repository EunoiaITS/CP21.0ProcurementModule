<!-- login from -->
<section class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="company-logo">
                <img src="<?php echo $this->request->webroot.'assets/img/logo.png'; ?>" alt="">
            </div>
            <h2 class="login-title">Please enter your username and password</h2>
            <form method="post" action="#" class="from-submit">
                <div class="form-group">
                    <label for="user-name-login">Username</label>
                    <input type="text"  name="username" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="user-name-login">Password</label>
                    <input type="password" name="password"  class="form-control"/>
                </div>
                <div class="btn-group">
                    <button type="submit" class="pull-left btn btn-default-login" style="margin-right:5px;">Login</button>
                    <button class="pull-right btn btn-default-login">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</section>