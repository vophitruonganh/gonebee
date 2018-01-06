<template>
    <transition name="slide-fade">
        <div class="container" style="padding:10px;">
            <div class="col-lg-3 text-center" style="background:#f4f4f4 !important; padding:10px;">
                <a class="text-center" href=""><img class="img-circle img-responsive center-block"
                                                    :src="'https://graph.facebook.com/v2.10/'+ user.fb_user_id +'/picture?width=150&height=150'"></a>
                <br><br>
                <a class="title text-center"><strong>{{ user.name }}</strong></a>
                <a class="title text-center text-default" :href="'malto:' + user.email"><small>{{ user.email }}</small></a><br>
                <a class="title text-center text-default" :href="user.fb_profile_link"><small>Facebook Profile</small></a><br><br>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="title text-center">Đã tặng: <small class="text-danger">{{ user.total_giver || 0}}</small></p>
                        </div>
                        <div class="col-lg-6">
                            <p class="title text-center">Đã nhận: <small class="text-success">{{ user.total_receiver || 0 }}</small></p>
                        </div>
                    </div>
                </div>
                <hr>
                <ul class="nav nav-pills nav-stacked text-left">
                    <li class="active"><router-link :to="'/user/bookstore/' + user.id">Sách của tôi</router-link></li>
                    <li class=""><router-link :to="'/user/bookstore/given'">Sách đã tặng</router-link></li>
                    <li class=""><router-link :to="'/user/bookstore/request'">Sách đang yêu cầu</router-link></li>
                    <li class=""><router-link :to="'/user/bookstore/receiver'">Bạn bè đang yêu cầu</router-link></li>


                </ul>
            </div>
            <div class="col-lg-9">
                <router-view></router-view>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: 'MyBook',
        props: {
            user: Object
        },
        data() {
            return {
                isActive: false
            }
        }
    }
</script>
