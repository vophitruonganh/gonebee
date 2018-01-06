<template>
    <div class="row">
        <div class="col-xs-12">
            <ul class="pagination pagination-sm justify-content-end">
                <li v-if="pagination.current_page > 1">
                    <a href="#" aria-label="Previous" v-on:click.prevent="changePage(pagination.current_page - 1)">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
                <li v-for="page in pagesNumber" :class="{'active': page == pagination.current_page}">
                    <a href="#" v-on:click.prevent="changePage(page)">{{ page }}</a>
                </li>
                <li v-if="pagination.current_page < pagination.last_page">
                    <a href="#" aria-label="Next" v-on:click.prevent="changePage(pagination.current_page + 1)">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
            <!-- <ul class="pager">
                <li><a v-on:click.prevent="changePage(pagination.current_page - 1)" href="#">Previous</a></li>
                <li><a v-on:click.prevent="changePage(pagination.current_page + 1)" href="#">Next</a></li>
            </ul> -->
            <!-- <ul class="pager">
                <li class="previous disabled"><a href="#" v-on:click.prevent="changePage(pagination.current_page - 1)" >&larr; Older</a></li>
                <li class="next" v-on:click.prevent="changePage(pagination.current_page + 1)"><a href="#">Newer &rarr;</a></li>
            </ul> -->
        </div>
    </div>
</template>
<script>
    export default{
        props: {
            pagination: {
                type: Object,
                required: true
            },
            offset: {
                type: Number,
                default: 4
            }
        },
        beforeUpdate(){
            this.pagesArray = [];
        },
        computed: {
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                for (from ; from <= to; from++) {
                    pagesArray.push(from);
                }
                return pagesArray;
            }
        },
        methods : {
            changePage: function (page) {
                this.pagination.current_page = page;
            }
        }
    }
</script>