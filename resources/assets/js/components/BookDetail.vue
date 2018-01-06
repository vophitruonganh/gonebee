<template>
	<div class="book-detail container">

		<div class="row">
			<div class="col-lg-3">
				<div class="panel panel-default">
					<!-- <div class="panel-heading">
						<div class="panel-title">{{ book.title || 'Loading...' }}</div>
					</div> -->
					<div class="panel-body">
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-lg-offset-2 col-md-offset-2">
							<img class="img-responsive img-thumbnail":src="book.thumbnail_url || '../../images/notebook_bookcover.png'" alt="Image Book">
						</div>
						<br><br>
						<div class="col-lg-12">
							<h5 class="text-center text-default"><strong>{{ book.title || 'Loading...' }}</strong></h5>
							<h5 class="text-center"><strong>Author: <small class="text-danger">{{ book.author || 'Loading...' }}</small></strong></h5>
							<h5 class="text-center"><strong>Giver: <small class="text-success">{{ book.giver.name || 'Loading...' }}</small></strong></h5>
							<hr>
							<button class="btn btn-success btn-sm"><i class="fa fa-cart-plus"></i>&nbsp;Receive</button>
							<button class="btn btn-warning btn-sm"><i class="fa fa-star"></i>&nbsp;Rating</button>
							<button class="btn btn-info btn-sm"><i class="fa fa-share"></i>&nbsp;Share</button>
						</div>
						<hr>
					</div>
				</div>
			</div>
			<div class="col-lg-9">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">Description</div>
					</div>
					<div class="panel-body">
						<p class="text-default">{{ book.description || 'Loading...' }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/css">
export default {
	name: 'BookDetail',
	data () {
		return {
			id: this.$route.params.id,
			book:{
				title: '',
				giver: '',
				author: '',
				description: '',
				thumbnail_url :'asda',
				rating: 0,
				given: 0
			},
			isLoading:true,
			errors: Object
		}
	},
	methods:{
		loadBookDetail(id){
			this.$Progress.start();
			this.axios.get(API + 'book/detail/' + id).then(response => {
				this.$Progress.finish();
				this.book = response.data;
			}).catch(response => {
				this.$Progress.fail();
				this.errors = reponse.data;
			});
		}
	},
	created(){
		this.loadBookDetail(this.id);
	},
	mounted(){

	}
}
</script>
