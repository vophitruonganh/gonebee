<template>
  <transition name="fade-slide" mode="out-in">
    <div class="modal fade" role="dialog" id="receiveBookModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-success">
            <h4 class="modal-title text-center">Xác nhận tặng sách</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="col-lg-3">
                          <router-link :to="'/book/detail/' + book.id.toString()">
                              <img class="img-responsive img-thumbnail"
                                   :src="book.thumbnail_url || '../../images/notebook_bookcover.png'"
                                   alt="Image Book">
                          </router-link>
                      </div>
                      <div class="col-lg-9">
                          <h6 class="text-default text-capitalize">
                              <router-link :to="'/book/detail/' + book.id.toString()">{{ book.title }}</router-link>

                          </h6>
                          <p><small class="text-default">Tác giả:<b class="text-danger"> {{ book.author }}</b></small></p>
                          <p><small class="text-default">Người tặng:<a class="text-success" :href="'https://facebook.com/' + book.giver.fb_user_id || 0">{{ book.giver.name || 'asdasd' }}</a></small></p>
                          <p><small class="text-default"><b>Số lượng: {{ book.quantity || 'Đã hết sách' }}</b></small></p>
                          <p><small class="text-default"><b>Đã tặng: {{ book.receiver.length}}</b></small></p>
                      </div>
                      <div class="col-lg-12">
                            <p class="text-justify">{{ book.description | truncate(200)}}</p>
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-body text-center">
              <button @click="receiverBook(book)" class="btn btn-success btn-sm">Nhận sách ngay</button>
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Hủy thao tác</button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'ReceiveBookModal',
    props:['user','book'],
  data () {
    return {
    }
  },
  methods:{

  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
