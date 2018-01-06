<template>
    <transition name="fade"  v-if="isLogin">
        <div class="container">
            <div class="col-lg-3 text-center">
                <div class="panel panel-default shadow">
                    <div class="panel-body with-3d-shadow">
                        <a class="text-center" href=""><img class="img-responsive img-thumbnail center-block"
                                                            :src="'https://graph.facebook.com/v2.10/'+ user.fb_user_id +'/picture?type=large'"></a>
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
                        <ul class="nav nav-divider nav-stacked text-left">
                            <li class="text-capitalize active"><router-link :to="'/user/bookstore/given'">Sách của tôi</router-link></li>
                            <li class="text-capitalize"><router-link :to="'/user/bookstore/received'">Sách tôi đã nhận</router-link></li>
                            <li class="text-capitalize"><router-link :to="'/user/bookstore/request'">Sách tôi yêu cầu</router-link></li>
                            <li class="text-capitalize"><router-link :to="'/user/bookstore/receive'">sách bạn bè yêu cầu</router-link></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-9" v-if="slug === 'receive'">
                <div class="panel panel-success shadow">
                    <div class="panel-heading"><div class="panel-title text-capitalize">{{ this.title_collection }}</div></div>
                    <div class="panel-body">
                        <transition-group name="fade">
                            <div :key="user.id" v-for="user in books">
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-center" v-for="book in user.receiver" :id="book.id" v-if="isLoading === false">
                                    <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-xs-8 col-xs-offset-2 ">
                                        <router-link :to="'/book/detail/' + book.id.toString()">
                                            <img class="img-responsive img-thumbnail"
                                                 :src="book.thumbnail_url || '../../images/notebook_bookcover.png'"
                                                 alt="Image Book">
                                        </router-link>
                                    </div>
                                    <div class="col-lg-12 col-xs-12">
                                        <h6 class="text-default text-capitalize">
                                            <router-link :to="'/book/detail/' + book.id.toString()"><strong>{{ book.title }}</strong></router-link>
                                        </h6>
                                        <p><small class="text-default">Tác giả:<b class="text-danger"> {{ book.author }}</b></small></p>
                                        <div v-if="slug == 'receive'" class="col-lg-12">
                                             <!--<p><small class="text-default">Danh mục: <b class="text-default" v-if="book.category !== null"> {{ book.category.title || 'Dang cap nhat' }}</b></small></p>-->
                                             <p><small class="text-default">Người yêu cầu: <b class="text-default"> {{ user.name }}</b></small></p>
                                            <!--<button @click="acceptReceive" class="btn btn-success btn-sm">Đồng ý</button>-->
                                            <button type="button" @click="setInfoBookAccept(book,user)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#acceptGiveBook"><i class="fa fa-check"></i>&nbsp;&nbsp;Đồng ý</button>
                                            <button @click="cancelReceive(book,user)" class="btn btn-danger btn-sm">Hủy</button>
                                        </div>
                                    </div>
                                </div>
                                <accept-give-book-button :book="bookAccept" :receiver="receiver"></accept-give-book-button>
                            </div>
                        </transition-group>
                        <div class="col-lg-12" v-if="isLoading === true"><p class="text-center"><i
                                class="fa fa-book"></i>&nbsp;Bạn chưa có sách cho mục này</p></div>
                        <div class="col-lg-12 text-center">
                            <vue-pagination v-if="isLoading === false" v-bind:pagination="this.pagination"
                                            :slug="slug"
                                            v-on:click.native="getBooksByTopic(slug,pagination.current_page)"
                                            :offset="4"></vue-pagination>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9" v-if="slug !== 'receive'">
                <div class="panel panel-success shadow">
                    <div class="panel-heading"><div class="panel-title text-capitalize"><strong>{{ this.title_collection }}</strong></div></div>
                    <div class="panel-body">
                        <transition-group name="fade">
                            <div :key="book.id" :id="book.id" class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-center" v-for="book in books" v-if="isLoading === false">
                                <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-xs-8 col-xs-offset-2 ">
                                    <router-link :to="'/book/detail/' + book.id.toString()">
                                        <img class="img-responsive img-thumbnail"
                                             :src="book.thumbnail_url || '../../images/notebook_bookcover.png'"
                                             alt="Image Book">
                                    </router-link>
                                </div>
                                <div class="col-lg-12 col-xs-12">
                                    <h6 class="text-default text-capitalize">
                                        <router-link :to="'/book/detail/' + book.id.toString()"><strong>{{ book.title }}</strong></router-link>
                                    </h6>
                                    <p><small class="text-default">Tác giả:<b class="text-danger"> {{ book.author }}</b></small></p>
                                    <div v-if="slug == 'receive'" class="col-lg-12">
                                        <!--<p><small class="text-default">Người yêu cầu: <b class="text-default"> {{ user.name }}</b></small></p>-->
                                        <button @click="acceptReceive" class="btn btn-success btn-sm">Đồng ý</button>

                                        <button @click="cancelReceive" class="btn btn-danger btn-sm">Hủy</button>
                                        <hr>
                                    </div>

                                </div>
                            </div>
                        </transition-group>
                        <div class="col-lg-12" v-if="isLoading === true"><p class="text-center"><i
                                class="fa fa-book"></i>&nbsp;Bạn chưa có sách cho mục này</p></div>
                        <div class="col-lg-12 text-center">
                            <vue-pagination v-if="isLoading === false" v-bind:pagination="this.pagination"
                                            :slug="slug"
                                            v-on:click.native="getBooksByTopic(slug,pagination.current_page)"
                                            :offset="4"></vue-pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import VuePagination from './Pagination'
    import AcceptGiveBookButton from'./AcceptGiveBookButton';
    export default {
        name: 'BookList',
        components: {
            VuePagination: VuePagination,
            AcceptGiveBookButton:AcceptGiveBookButton
        },
        props:{
          user:Object
        },
        data() {
            return {
                pagination: {
                    total: 0,
                    per_page: 2,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                books: Object,
                bookAccept:Object,
                receiver:Object,
                title_collection: null,
                isLoading: true,
                isLogin:false,
                slug: this.$route.params.userID,
            }
        },
        methods: {
            start () {
                this.$Progress.start()
            },
            set (num) {
                this.$Progress.set(num)
            },
            increase (num) {
                this.$Progress.increase(num)
            },
            decrease (num) {
                this.$Progress.decrease(num)
            },
            finish () {
                this.$Progress.finish()
            },
            fail () {
                this.$Progress.fail()
            },
            getBooksByTopic(slug, page) {
                this.$Progress.start();
                if(slug !== undefined){
                    this.axios.post(API + 'user/book/'+ slug +'?page=' + page).then(response => {
                        this.books = response.data.data;
                        this.pagination = response.data;
                        if (this.books.length > 0) {
                            this.isLoading = false;
                        } else {
                            this.isLoading = true;
                        }
                        this.$Progress.finish();
                    }).catch(response => {
                        this.$Progress.fail();
                        this.errors = response.data
                    })
                }else{
                    this.axios.post(API + 'user/book/mybook/?page=' + page).then(response => {
                        this.books = response.data.data
                        this.pagination = response.data
                        if (this.books.length > 0) {
                            this.isLoading = false;
                        } else {
                            this.isLoading = true;
                        }
                        this.$Progress.finish();
                    }).catch(response => {
                        this.$Progress.fail();
                        this.errors = response.data
                    })
                }
            },
            acceptReceive(){
                 toastr.success('Đang gửi yêu cầu tặng sách');
            },
            cancelReceive(book,user){
                this.axios.post(API + 'user/book/cancel-give',{
                    book_id:book.id,
                    receiver_id:user.id
                }).then(response => {
                    this.$Progress.finish();
                    toastr.warning('Hủy tặng sách ' + book.title + ' thành công');
                    $("#"+ book.id).hide();
                }).catch(response => {
                    this.$Progress.fail();
                    toastr.error('Thao tác thất bại, liên hệ với quản trị viên để được hỗ trợ');
                    this.errors = response.data
                })
            },
            translateTitle(){
                switch (this.slug) {
                    case 'given':
                        this.title_collection = 'Sách của tôi';
                        break;
                    case 'receive':
                        this.title_collection = 'Yêu cầu từ bạ bè';
                        break;
                    case 'request':
                        this.title_collection = 'Sách tôi yêu cầu';
                        break;
                    default:
                        this.title_collection = 'Sách của tôi';
                        break;
                }
            },
            setInfoBookAccept(book,receiver){
                this.bookAccept =  book;
                this.receiver = receiver;
            }
        },
        watch: {
            '$route.params.userID'(newID, oldID) {
                this.slug = newID;
                this.translateTitle();
                this.books = this.getBooksByTopic(newID, this.pagination.current_page);
            }
        },
        beforeCreate(){

        },
        created() {

            if(this.user === undefined || this.user === null){
                window.location.href = '/';
            }else{
                this.isLogin = true;
                this.translateTitle();
                this.getBooksByTopic(this.slug, this.pagination.current_page);
            }
        },
        mounted() {
        }
    }
</script>
