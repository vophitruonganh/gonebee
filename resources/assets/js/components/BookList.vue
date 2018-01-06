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
                        <div class="panel-title text-uppercase text-left">Thư Viện Sách</div>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-3 text-center" v-for="book in books" v-if="isLoading === false">
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
                            <small class="text-default"><b>Author: </b>{{ book.author }}</small>
                            <br>
                            <small class="text-default"><b>Giver: {{ book.giver.name}}</b></small>
                            <hr>
                        </div>
                        <div class="col-lg-12" v-if="isLoading === true"><p class="text-center"><i
                                class="fa fa-book"></i>&nbsp;Chua co sach</p></div>
                        <div class="text-center">
                            <vue-pagination v-if="isLoading === false" v-bind:pagination="this.pagination"
                                            :slug="categoryID"
                                            v-on:click.native="loadAllBooks(categoryID,pagination.current_page)"
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

    export default {
        name: 'BookList',
        components: {
            VuePagination: VuePagination
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
            loadAllBooks(category, page) {
                this.axios.get(API + 'books?page=' + page).then(response => {
                    this.books = response.data.data
                    this.pagination = response.data
                    if (this.books.length > 0) {
                        this.isLoading = false;
                    } else {
                        this.isLoading = false;
                        this.isLoading = true;
                    }
                }).catch(response => {
                    this.errors = response.data
                })
            },
            loadCategories() {
                this.axios.get(API + 'category').then(response => {
                    this.categories = response.data
                }).catch(response => {
                    this.errors = response.data
                });
            },

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
