<template>
  <div class="login container">
    <div class="col-lg-4 col-lg-offset-4">
      <div class="panel panel-success">
      <div class="panel-heading">
        <div class="panel-title">Login</div>
      </div>
      <div class="panel-body">
        <form action="" class="form-horizontal col-lg-12">
          <div class="form-group">
            <label class="control-label pull-left">Username</label>
            <input class="form-control" type="text" name="username" placeholder="Username" required>
          </div>
          <div class="form-group">
            <label class="control-label pull-left">Password</label>
            <input class="form-control" type="text" name="username" placeholder="Username" required>
          </div>
          <div class="form-group">
            <!-- <button class="btn btn-primary"><i class="fa fa-user-circle-o"></i>&nbsp;Login</button> -->
            <button class="btn btn-default"><i class="fa fa-sign-in"></i>&nbsp;Login</button>
          </div>
          <div class="form-group">
            <p><a class="text-primary">Forgot password</a></p>
          </div>
          <hr>
          <div class="form-group">
            <p class="text-center"><strong>Login with social network</strong></p>
            <div class="col-lg-10 col-lg-offset-1">
              <a class="btn btn-block btn-social btn-facebook"><span class="fa fa-facebook"></span> Sign in with Facebook</a>
            
            <a class="btn btn-block btn-social btn-google"><span class="fa fa-google"></span> Sign in with Google</a>
            </div>
          </div>
        </form>
      </div>
    </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Logint',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->