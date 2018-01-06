<template>
	<transition name="fade-slide" mode="out-in">
		<div class="modal fade" role="dialog" id="acceptGiveBook">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header bg-success">
						<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
						<h4 class="modal-title text-center">Xác nhận tặng sách</h4>
					</div>
					<div class="modal-body text-center">
						<button type="button" class="btn btn-success" v-on:click="confirmAcceptGiveBook(book,receiver)">Xác nhận tặng sách</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Hủy thao tác</button>
					</div>
				</div>
			</div>
		</div>
	</transition>
</template>

<script>
	export default {
		name: 'AcceptGiveBookButton',
		props: ['user','book','receiver'],
		data() {
			return {
				userInfo: this.user,
				errors: Object,
				isLoading: false,
				isLogin: false,
				isError: false,
				total: 0
			}
		},
		methods: {
			confirmAcceptGiveBook(){
				if(this.book === undefined){
					toastr.error('Book not exist');
				}else{
					this.axios.post(API + 'user/book/accept-give',{
						book_id:this.book.id,
						receiver_id:this.receiver.id
					}).then(response =>{
						if(response.data.status !== 200){
							toastr.error(response.data.msg);
						}else{
							toastr.success(response.data.msg);
						}
					}).catch(errors => {
						this.errors = errors.response;
					});
					Echo.private('accept-give-book')
						.listen('AcceptGiveBookEvent', response => {
							console.log(response);
							// $('#content').append(`<div class="well">${e.message}</div>`);
						});
				}
			}
		},
		created() {

		},
		mounted() {

		}
	}
</script>
