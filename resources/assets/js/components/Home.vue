<template>
    <div class="home container-full">
        <feature></feature>
        <book-feature :user="user" :title="'Sách Mới'"></book-feature>
        <book-feature :user="user" :title="'Sách Đang Cầu'"></book-feature>
        <book-feature :user="user" :title="'Sách Tặng Nhiều'"></book-feature>
    </div>
</template>

<script>
    import Feature from './Feature.vue';
    import BookFeature from './BookFeature.vue'

    export default {
        name: 'Home',
        props: {
            user: {}
        },
        components: {
            Feature: Feature,
            BookFeature: BookFeature
        },
        data() {
            return {
                msg: 'Welcome to Your Vue.js App'
            }
        },
        created(){
            this.$Progress.start();
        },
        mounted(){
            this.$Progress.finish();
        }
    }
</script>
