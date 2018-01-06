<template>
  <div class="footer">
      <footer id="myFooter">
          <div class="container">
              <div class="row">
                  <div class="col-sm-3">
                      <h5>Get started</h5>
                      <ul>
                          <li><router-link to="/">Home</router-link></li>
                          <li><router-link to="/sig-up">Sign up</router-link></li>
                      </ul>
                  </div>
                  <div class="col-sm-3">
                      <h5>Về chúng tôi</h5>
                      <ul>
                          <li><a href="https://facebook.com/vophitruonganh" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i>&nbsp;&nbsp;Võ Phi Trường Anh</a></li>
                          <li><a href="https://www.facebook.com/ntuanphuc" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i>&nbsp;&nbsp;
                              Nguyễn Tuấn Phúc</a></li>

                      </ul>
                  </div>
                  <div class="col-sm-3">
                      <h5>Kênh hỗ trợ</h5>
                      <ul>
                          <li><a href="#">Thông tin tài khoản</a></li>
                          <li><a href="#">Thư viện sách</a></li>
                      </ul>
                  </div>
                  <div class="col-sm-3 info">
                      <h5>Bắt đâu ý tưởng</h5>
                      <p> Chúng tôi mong muốn tại ra 1 mạng xã hội kết nối mọi người với nhau qua sự chia sẽ.<br>Rất nhiều người trên thế giới đang càn sự sẽ chia về vật chất và tinh thần.<br>Hãy chung tay chia sẽ nhưng thứ nhỏ nhặt mà bạn có, vì 1 cuộc sống tốt đẹp hơn.</p>
                  </div>
              </div>
          </div>
          <div class="second-bar">
              <div class="container">
                  <h2 class="logo"><a href="#"> {{ sitename }} </a></h2>
                  <div class="social-icons">
                      <a href="#" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a>
                      <a href="https://facebook.com/freenovels" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a>
                      <a href="#" target="_blank" class="google"><i class="fa fa-google-plus"></i></a>
                  </div>
              </div>
          </div>
      </footer>
  </div>
</template>

<script>

export default {
  name: 'About',
    props:{
      sitename:null,
    },
  data () {
    return {
//      msg: 'Welcome to Your Vue.js App'
    }
  }
}
</script>
<style>
    #myFooter {
        background-color: #3a3f46;
        color: white;
    }

    #myFooter .row {
        margin-bottom: 60px;
    }

    #myFooter .info{
        text-align: justify;
        color: #afb0b1;
    }

    #myFooter ul {
        list-style-type: none;
        padding-left: 0;
        line-height: 1.7;
    }

    #myFooter h5 {
        font-size: 18px;
        color: white;
        font-weight: bold;
        margin-top: 30px;
    }

    #myFooter .logo{
        margin-top: 10px;
    }

    #myFooter .second-bar .logo a{
        color:white;
        font-size: 28px;
        float: left;
        font-weight: bold;
        line-height: 68px;
        margin: 0;
        padding: 0;
    }

    #myFooter a {
        color: #d2d1d1;
        text-decoration: none;
    }

    #myFooter a:hover,
    #myFooter a:focus {
        text-decoration: none;
        color: white;
    }

    #myFooter .second-bar {
        text-align: center;
        background-color: #33373e;
        text-align: center;
    }

    #myFooter .second-bar a {
        font-size: 22px;
        color: #9fa3a9;
        padding: 10px;
        transition: 0.2s;
        line-height: 68px;
    }

    #myFooter .second-bar a:hover {
        text-decoration: none;
    }

    #myFooter .social-icons {
        float:right;
    }


    #myFooter .facebook:hover {
        color: #0077e2;
    }

    #myFooter .google:hover {
        color: #ef1a1a;
    }

    #myFooter .twitter:hover {
        color: #00aced;
    }

    @media screen and (max-width: 767px) {
        #myFooter {
            text-align: center;
        }

        #myFooter .info{
            text-align: center;
        }
    }



    /* CSS used for positioning the footers at the bottom of the page. */
    /* You can remove this. */

    html{
        height: 100%;
    }

    body{
        display: flex;
        display: -webkit-flex;
        flex-direction: column;
        -webkit-flex-direction: column;
        height: 100%;
    }

    .content{
        flex: 1 0 auto;
        -webkit-flex: 1 0 auto;
        min-height: 200px;
    }

    #myFooter{
        flex: 0 0 auto;
        -webkit-flex: 0 0 auto;
        position: auto;
        bottom: 0px;
        left: 0px;
        right: 0px;
        margin-bottom: 0px;
    }
</style>
