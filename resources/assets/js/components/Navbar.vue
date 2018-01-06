<template>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <router-link class="navbar-brand" to="/">{{ sitename }}</router-link>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav">
                    <li><router-link to="/books">Books Store</router-link></li>
                    <!-- <li><router-link to="/news">News</router-link></li> -->
                    <li><router-link to="/contact">Contact Us</router-link></li>
                </ul>
                <ul class="nav navbar-nav navbar-right" v-if="isLogin === false">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><i class="fa fa-user-circle-o"></i>&nbsp;&nbsp;Đăng nhập</b> <span class="caret"></span></a>
                        <ul id="login-dp" class="dropdown-menu">
                            <li>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center">Login with social network</p>
                                        <div class="social-buttons">
                                            <login-facebook-button v-on:increment="changeLogin"></login-facebook-button>
                                        </div>
                                        <hr>
                                        <p class="text-center">Sử dụng tài khoản của chúng tôi</p>
                                        <form class="form" role="form" method="post" action="login"
                                              accept-charset="UTF-8" id="login-nav">
                                            <div class="form-group">
                                                <label class="sr-only"
                                                       for="exampleInputEmail2">Email address</label>
                                                <input type="email" class="form-control" id="exampleInputEmail2"
                                                       placeholder="Địa chỉ email" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                <input type="password" class="form-control"
                                                       id="exampleInputPassword2" placeholder="Mật khẩu" required>
                                                <div class="checkbox"><label><input type="checkbox">
                                                    Ghi nhớ tài khoản</label></div>
                                                <div class="help-block text-right"><a
                                                        href="">Bạn quên mật khẩu ?</a></div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-block">Đăng nhập
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="bottom text-center"><a href="#"><b>Đăng ký ngay</b></a></div>
                                </div>
                            </li>
                        </ul>

                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right" v-if="isLogin === true">
                    <li><a href="" id="giveBook"><i class="fa fa-send"></i></a></li>
                    <!-- <li><i class="fa fa-send"><a href="" id="giveBook"></a></li>
                    <li><i class="fa fa-send"><a href="" id="giveBook"></a></li> -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img class="img-circle"
                                 :src="'https://graph.facebook.com/v2.10/'+ user.fb_user_id +'/picture?width=22&height=22'">
                            <b>&nbsp;&nbsp;{{ user.name }}</b>
                            <span class="caret"></span>
                        </a>
                        <ul id="login-dp1" class="dropdown-menu">
                            <li><router-link :to="'/user/bookstore/given'"><i class="fa fa-home"></i>&nbsp;&nbsp;Sách của tôi</router-link></li>
                            <li><router-link :to="'/user/profile/' + user.id"><i class="fa fa-cogs"></i>&nbsp;&nbsp;Thiết lập tài khoản</router-link></li>
                            <li><a @click="signOut"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Đăng xuất</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
//     Echo.private('give-book')
//     .listen('GiveBookEvent', (e) => {
//         console.log(e);
//         // $('#content').append(`<div class="notifyGiveBook">${e.message}</div>`);
//         $('#notifyGiveBook').val(e.message);
//     });

// Echo.private('cancel-give-book')
//     .listen('CancelGiveBookEvent', (e) => {
//         console.log(e);
//         // $('#content').append(`<div class="notifyCancelGiveBook">${e.message}</div>`);
//         $('#notifyCancelGiveBook').val(e.message);
//     });

// Echo.private('accept-give-book')
//     .listen('AcceptGiveBookEvent', (e) => {
//         console.log(e);
//         // $('#content').append(`<div class="notifyAcceptGiveBook">${e.message}</div>`);
//         $('#notifyAcceptGiveBook').val(e.message);
//     });
</script>
<script>
    import LoginFacebookButton from './LoginFacebookButton';
    export default {
        name: 'Navbar',
        components: {
            LoginFacebookButton: LoginFacebookButton
        },
        props: ['sitename', 'user'],
        data() {
            return {
                categories: Object,
                userInfo: this.user,
                errors: Object,
                isLogin: false,
            }
        },
        methods: {
            getCategory() {
                this.axios.post(API + 'category').then(response => {
                    this.categories = response.data;
                }).catch(response => {
                    this.errors = response.errors
                });
            },
            changeLogin() {
                if (this.user === undefined ||  this.user === null) {
                    this.isLogin = false;
                } else {
                    this.isLogin = true;
                }
            },
            signOut(){
                this.axios.post('/logout').then(response => {
                   window.location.reload();
                }).catch(response => {
                    this.errors = response.data;
                });
            }
        },
        created() {
            this.getCategory();
            this.changeLogin();
        }
    }
</script>
<style>
    #login-dp {
        min-width: 250px;
        padding: 14px 14px 0;
        overflow: hidden;
        background-color: rgba(255, 255, 255, .8);
    }

    #login-dp .help-block {
        font-size: 12px
    }

    #login-dp .bottom {
        background-color: rgba(255, 255, 255, .8);
        border-top: 1px solid #ddd;
        clear: both;
        padding: 14px;
    }

    #login-dp .social-buttons {
        margin: 12px 0
    }

    #login-dp .social-buttons a {
        /* width: 49%; */
        with: auto;
    }

    #login-dp .form-group {
        margin-bottom: 10px;
    }

    .btn-fb {
        color: #fff;
        background-color: #3b5998;
    }

    .btn-fb:hover {
        color: #fff;
        background-color: #496ebc
    }

    .btn-tw {
        color: #fff;
        background-color: #55acee;
    }

    .btn-tw:hover {
        color: #fff;
        background-color: #59b5fa;
    }

    @media (max-width: 768px) {
        #login-dp {
            background-color: inherit;
            color: #fff;
        }

        #login-dp .bottom {
            background-color: inherit;
            border-top: 0 none;
        }
    }
</style>
