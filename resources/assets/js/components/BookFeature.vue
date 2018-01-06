<template>
    <transition name="fade">
        <div class="book-feature container">
            <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title text-uppercase text-left"><i
                                class="fa fa-book"></i>&nbsp;&nbsp;{{ title || "Dang cap nhat" }}
                        </div>
                    </div>
                    <div class="panel-body">
                        <div :key="book.id" class="col-lg-2 text-center" v-for="book in books" v-if="isLoading === false">
                            <img class="img-responsive img-thumbnail"
                                 :src="book.thumbnail_url || '../../images/notebook_bookcover.png'"
                                 alt="Image Book">
                            <br><br>
                            <h6 class="text-default text-capitalize">
                                <strong>
                                    <router-link :to="'/book/detail/' + book.id.toString()">{{ book.title }}
                                    </router-link>
                                </strong>
                            </h6>
                            <small class="text-default">Tác giả:<b class="text-danger"> {{ book.author }}</b></small>
                            <br>
                            <small v-if="book.giver !== null" class="text-default">Người tặng:<a class="text-success" :href="'https://facebook.com/' + book.giver.fb_user_id || 0"> {{ book.giver.name }}</a></small>
                            <small v-else-if="book.giver === null" class="text-default">Người tặng:<a class="text-success">&nbsp;Đang cập nhật</a></small>
                            <br>
                            <small class="text-default"><b>Số lượng: {{ book.quantity?book.quantity:0 || 'Đã hết sách' }}</b></small>
                            <br>
                            <small class="text-default"><b>Đã tặng: {{ book.quantity - book.total_receiver?book.total_receiver:0}}</b></small>
                            <br><br>
                            <div class="col-lg-12">
                                <div class="row">
                                    <button @click="receiverBook(book.id)" class="btn btn-success btn-sm">Nhận sách ngay</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" v-if="isLoading === true">
                            <p class="text-center">Loading <img src="../../images/loading_icon.gif"></p>
                        </div>

                        <div class="text-center col-lg-12">
                            <hr>
                            <vue-pagination v-if="isLoading === false" v-bind:pagination="this.pagination" :slug="categoryID" v-on:click.native="loadAllBooks(categoryID,pagination.current_page)" :offset="4"></vue-pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import VuePagination from './Pagination'

    export default {
        name: 'BookFeature',
        components: {
            VuePagination: VuePagination
        },
        props: {
            title: null,
            user: Object
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
                isLoading: true,
                isEmpty: true
            }
        },
        methods: {
            loadAllBooks(category,page) {
                this.$Progress.start();
                this.axios.post(API + 'books?page=' + page + '&limit=6').then(response => {
                    this.books = response.data.data;
                    this.pagination = response.data;
                    if (this.books.length > 0) {
                        this.isLoading = false;
                        this.isEmpty = false;
                    } else {
                        this.isLoading = false;
                        this.isEmpty = true;
                    }
                    this.$Progress.finish();
                }).catch(response => {
                    this.$Progress.fail();
                    this.errors = response.data
                })
            },
            loadCategories() {
                this.axios.post(API + 'category').then(response => {
                    this.categories = response.data.data
                }).catch(response => {
                    this.errors = response.data
                });
            },
            receiverBook(bookID){
                if(this.user === undefined || this.user === null){
                    toastr.warning('Vui lòng đăng nhập để nhận sách');
                }else{
                    let params = {
                        book_id: bookID,
                        user_id: this.user.fb_user_id
                    };
                    this.axios.post(API + 'user/receive-book',params).then(response => {
                        if(response.data.status === 1){
                            toastr.success(response.data.msg);
                        }else{
                            toastr.error(response.data.msg);
                        }
                    }).catch(response => {
                        toastr.error(response.data.msg);
                    });
                }
            }
        },
        watch: {
            '$route.params.category'(newID, oldID) {
                this.books = this.loadAllBooks(newID, this.pagination.current_page);
                this.loadCategories();
            }
        },
        created() {
            this.loadAllBooks(this.categoryID, this.pagination.current_page);
            this.loadCategories();
        },
        mounted() {
        }
    }
</script>
