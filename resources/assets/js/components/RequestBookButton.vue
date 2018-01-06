<template>
  <transition name="fade-slide" mode="out-in">
    <div id="requestBook" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h4 class="modal-title text-center text-primary text-uppercase">Yêu cầu sách từ bạn bè</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal">
              <fieldset>
                <div class="form-group">
                  <label for="bookName" class="col-lg-2 control-label">Tên sách</label>
                  <div class="col-lg-10">
                    <input type="text" class="form-control" id="bookName" placeholder="Tên sách mà bạn yêu cầu" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="bookQuantity" class="col-lg-2 control-label">Số lượng</label>
                  <div class="col-lg-10">
                    <input type="number" min="0" value="1" class="form-control" id="bookQuantity" placeholder="Số lượng sách của bạn" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="category" class="col-lg-2 control-label">Danh mục sách</label>
                  <div class="col-lg-10">
                    <select  class="form-control" id="select" placeholder="Chọn danh mục sách" required>
                      <option value=""></option>
                      <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-10 col-lg-offset-2 text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-warning" @click="requestBook">Yêu cầu sách</button>

                  </div>
                </div>
              </fieldset>
            </form>
          </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>

          </div> -->
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'GiveBookButton',
    props:['user','categories'],
  data () {
    return {
      userInfo: this.user,
      errors: Object,
      isLoading: false,
      isLogin: false,
      total:0
    }
  },
  methods:{
//    loadCategories() {
//        this.axios.get('category').then(response => {
//            this.categories = response.data
//        }).catch(response => {
//            this.errors = response.data
//        });
//    },
    requestBook(){
      toastr.success('Send request book');
    }
  },
  created(){
//    this.loadCategories();
  },
  mounted(){

  }
}
</script>
