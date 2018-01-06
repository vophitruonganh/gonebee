<template>
  <transition name="fade-slide" mode="out-in">
    <div id="giveBook" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-success">
            <h4 class="modal-title text-center text-primary text-uppercase">Chia sẻ sách</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal">
              <fieldset>
                <div class="form-group">
                  <label for="bookName" class="col-lg-2 control-label">Tên sách</label>
                  <div class="col-lg-10">
                    <input type="text" class="form-control" v-model="bookName" id="bookName" placeholder="Tên sách mà bạn tặng">
                    <span class="help-block has-error error" v-if="isError">
                        <strong>{{ errors.name[0]}}</strong>
                    </span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="bookQuantity" class="col-lg-2 control-label">Số lượng</label>
                  <div class="col-lg-10">
                    <input type="number" min="0" value="1" v-model="bookQuantity" class="form-control" id="bookQuantity" placeholder="Số lượng sách của bạn" required>
                    <span class="help-block has-error error" v-if="errors.quantity > 0">
                        <strong>{{ errors.description[0]}}</strong>
                    </span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-2 control-label">Danh mục sách</label>
                  <div class="col-lg-10">
                    <select  class="form-control" id="select" v-model="bookCategory" placeholder="Chọn danh mục sách" required>
                      <option value=""></option>
                      <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-2 control-label">Description</label>
                  <div class="col-lg-10">
                    <textarea class="form-control" v-model="bookDescription" placeholder="Mô tả của bạn tối đa 150 ký tự" rows="3" id="book_descrption"></textarea>
                    <span class="help-block" v-if="isError === false">Bạn có thể mô tả thông tin sách bạn muốn chia sẻ tại đây</span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-10 col-lg-offset-2 text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-success" v-on:click="giveBook()">Tặng sách</button>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
export default {
  name: 'GiveBookButton',
    props:['user','categories'],
  data() {
    return {
      userInfo: this.user,
//      categories: Object,
      bookName: null,
      bookDescription: null,
      bookQuantity: null,
      bookCategory: null,
      errors: Object,
      isLoading: false,
      isLogin: false,
      isError: false,
      total:0,
    }
  },
  methods:{
//    loadCategories() {
//        this.axios.get('/category').then(response => {
//            this.categories = response.data
//        }).catch(response => {
//            this.errors = response.errors
//        });
//    },
    giveBook(){
      let newBook = {
        name: this.bookName,
        description: this.bookDescription,
        quantity: this.bookQuantity,
        category: this.bookCategory
      }
      this.axios.post('/book/give',newBook).then(response => {
          if(response.data.status === 200){
            toastr.success("Tặng sách thành công ^^");
            $("#giveBook").modal('hide');
          }else{
            toastr.error(response.data.msg);
          }
          console.log(response.data);
      }).catch(error => {
        this.errors = error.response.data.errors;
        this.isError = true;
      });
    }
  },
  created(){
//    this.loadCategories();
  }
}
</script>
