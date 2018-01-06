<template>
  <transition name="fade-slide" mode="out-in">
    <a href="/login/facebook" class="btn btn-block btn-social btn-facebook">
      <span class="fa fa-facebook"></span> Sử dụng tài khoản Facebook
    </a>
  </transition>
</template>

<script>
export default {
  name: 'LoginFacebookButton',
    props:['user'],
  data () {
    return {
      userInfo: this.user,
      errors: Object,
      isLoading: false,
      isLogin: false,
      total:0
    }
  },
  methods:{
    checkLogin(){
      if(this.userInfo === undefined){
        this.isLogin = false;
      }else{
        this.isLogin = true;
      }
      this.$emit('increment');
    },
    login(){
        this.axios({
            url: '/authorize',
            method:'get'
        }).then(response => {
           this.userInfo = response.data;
           if (this.userInfo !== undefined){
               localStorage.setItem('userInfo',this.userInfo);
           }
        }).catch(response => {
            this.errors = response.data;
        });
    },
  },
  created(){
  },
  mounted(){

  }
}
</script>
