<template>
    <transition name="fade">
        <div class="hello container">
            <div class="col-lg-3">
                <ul class="list-group">
                    <li class="list-group-item" v-for="category in categories">
                        <!-- <span class="badge">14</span> -->
                        <router-link :to="'/book/category/'+ category.id.toString()">{{ category.name }}</router-link>
                    </li>
                </ul>
            </div>
            <div class="col-lg-9">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title text-left">{{ categoryName || "Thư Viện Sách" }}</div>
                    </div>
                    <div class="panel-body">
                        <transition-group name="fade">
                            <div :key="book.id" class="col-lg-3 text-center" v-for="book in books" v-if="isLoading === false">
                                <router-link :to="'/book/detail/' + book.id.toString()">
                                    <img class="img-responsive img-thumbnail"
                                         :src="book.thumbnail_url || '../../images/notebook_bookcover.png'"
                                         alt="Image Book">
                                </router-link>
                                <h6 class="text-default text-capitalize">
                                    <router-link :to="'/book/detail/' + book.id.toString()">{{ book.title }}</router-link>

                                </h6>
                                <p><small class="text-default">Tác giả:<b class="text-danger"> {{ book.author }}</b></small></p>
                                <p><small class="text-default">Người tặng:<a class="text-success" :href="'https://facebook.com/' + book.giver.fb_user_id || 0">{{ book.giver.name || 'asdasd' }}</a></small></p>
                                <p><small class="text-default"><b>Số lượng: {{ book.quantity || 'Đã hết sách' }}</b></small></p>
                                <p><small class="text-default"><b>Đã tặng: {{ book.receiver.length}}</b></small></p>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#receiveBookModal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Yêu cầu sách</button>
                                <!--<button @click="receiverBook(book)" class="btn btn-success btn-sm">Nhận sách ngay</button>-->
                                <receive-book-modal :book="book"></receive-book-modal>
                                <br><br>
                            </div>

                        </transition-group>
                        <div class="col-lg-12" v-if="isLoading === true">
                            <p class="text-center">Danh mục này chưa có sách</p>
                            <p class="text-center">Bạn có thể tặng sách hoặc yêu cầu sách mà bạn cần</p>
                            <div class="col-lg-12 text-center ">
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#giveBook"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tặng sách</button>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#requestBook"><i class="fa fa-bell"></i>&nbsp;&nbsp;Yêu cầu sách</button>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <vue-pagination v-if="isLoading === false" v-bind:pagination="this.pagination"
                                            :slug="categoryID"
                                            v-on:click.native="getBooksByCategory(categoryID,pagination.current_page)"
                                            :offset="4"></vue-pagination>
                        </div>
                    </div>
                </div>
            </div>
            <give-book-button :user="this.user" :categories="categories"></give-book-button>
            <request-book-button :user="this.user" :categories="categories"></request-book-button>
        </div>
    </transition>
</template>

<script>
    import VuePagination from './Pagination'
    import GiveBookButton from './GiveBookButton'
    import RequestBookButton from './RequestBookButton'
    import ReceiveBookModal from './ReceiveBookModal'

    export default {
        name: 'BookList',
        components: {
            VuePagination: VuePagination,
            GiveBookButton:GiveBookButton,
            RequestBookButton:RequestBookButton,
            ReceiveBookModal:ReceiveBookModal
        },
        props:{
            user: Object,
            categoryName: null,
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
                categoryID: this.$route.params.category,
                books: Object,
                categories: Object,
                isLoading: true
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
            getBooksByCategory(category, page) {
                this.$Progress.start();
                if(category === undefined){
                    this.axios.post(API + 'books?page=' + page).then(response => {
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
                        this.errors = response;
                        console.log(this.errors);
                    })
                }else{
                    this.axios.post(API + 'category/' + category + '?page=' + page).then(response => {
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
                }
            },
            loadCategories() {
                this.axios.post(API + 'category').then(response => {
                    this.categories = response.data.data;
                }).catch(response => {
                    this.errors = response.data
                });
            },
            receiverBook(book){
                if(this.user === undefined || this.user === null){
                    toastr.warning('Vui lòng đăng nhập để nhận sách');
                }else{
                    let params = {
                        book_id: book.id,
                        user_id: this.user.fb_user_id
                    };
                    this.axios.post(API + '/user/receive-book',params).then(response => {
                        if(response.data.status === 1){
                            toastr.success(response.data.msg);
                        }else{
                            toastr.error(response.data.msg);
                        }
                    }).catch(response => {
                        toastr.error(response.data.msg);
                    });
                }
            },
        },
        watch: {
            '$route.params.category'(newID, oldID) {
                this.books = this.getBooksByCategory(newID, this.pagination.current_page);
                // this.loadCategories();
            }
        },
        created() {
            this.getBooksByCategory(this.categoryID, this.pagination.current_page);
            this.loadCategories();
        },
        mounted() {
        }
    }
</script>
