<template>
  <transition name="fade">
    <div class="container">
    <h3 class="text-center text-uppercase">Liên hệ với chúng tôi</h3>
    <br>
      <div class="panel panel-default">
        <!-- <div class="panel-heading">
          <h1 class="panel-title">asdasd</h1>
        </div> -->
        
        <div class="panel-body">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.3821080321954!2d106.69478571432045!3d10.782018292317751!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f36586e9773%3A0xf839a9565a1906c4!2zNiBQaOG6oW0gTmfhu41jIFRo4bqhY2gsIHBoxrDhu51uZyA2LCBRdeG6rW4gMywgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1512804905363" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
      </div>
      <div class="panel panel-default">
        <!-- <div class="panel-heading">
          <h1 class="panel-title">asdasd</h1>
        </div> -->
        
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-12">
              <h3 class="text-center text-uppercase">Thành viên sáng lập</h3>
              <br>
            </div>
            <div class="col-lg-6">
              <h5 class="text-center"><img class="img-responsive img-thumbnail" src="https://graph.facebook.com/v2.10/503129750025506/picture?width=240&height=240" alt="Truong anh"></h5>
              <h5 class="text-center">Võ Phi Trường Anh</h5>
              <h5 class="text-center">Company: <i class="text-success">Socialone</i></h5>
              <h5 class="text-center">Position: Developper Engineer</h5>
              <!-- <p class="text-justify">asdasdad</p> -->
            </div>
            <div class="col-lg-6">
              <h5 class="text-center"><img class="img-responsive img-thumbnail" src="https://graph.facebook.com/v2.10/10152238301693542/picture?width=240&height=240" alt="Truong anh"></h5>
              <h5 class="text-center">Nguyễn Tuấn Phúc</h5>
              <h5 class="text-center">Company: <i class="text-success">Socialone</i></h5>
              <h5 class="text-center">Position: Founder Socialone</h5>
              <!-- <p class="text-justify">asdasdad</p> -->
            </div>
          </div>
        </div>
      </div>  
    </div>
  </transition>
</template>

<script>
export default {
  name: 'HelloWorld',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  },
  created(){
    this.$Progress.start();
  },mounted(){
    this.$Progress.finish();
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
  color: #42b983;
}
</style>
