<template>
    <div>
        <h2 class="text-center">Permintaan Barang</h2>
        <button class="btn btn-success float-right mb-2" data-toggle="modal" data-target="#productModal" data-backdrop="static" data-keyboard="false">Tambah</button>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pemesanan</th>
                    <th>Tanggal Pesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="productRequest, index in productRequests.data" :key="index">
                    <td>{{index + currentPage}}</td>
                    <td>{{ productRequest.customer.name }}</td>
                    <td>{{ productRequest.date_product_request }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <router-link :to="{name: 'edit', params: {id: productRequest.id}}" class="btn btn-success">Edit</router-link>
                            <button class="btn btn-danger" @click="deleteProduct(productRequest.id)">Hapus</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <pagination align="right" :data="productRequests" @pagination-change-page="list"></pagination>

        <div id="productModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Permintaan Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Proses</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import pagination from 'laravel-vue-pagination'
    export default {
       components: {
           pagination
       },
       data(){
         return{
           productRequests:[],
           currentPage: 1
         }
        },
        mounted() {
            this.list()
        },

       methods:{
           async list(page = 1) {
              await axios.get(`http://localhost:8000/api/product_requests?page=${page}`).then(({data})=>{
                 this.productRequests = data
                 this.currentPage = page > 1 ? page * 10 + 1 : page
              }).catch(({ response })=>{
                 console.error(response)
              })
           },
           deleteProduct(id){
               debugger
               this.$swal({
                   title: 'Apakah Anda yakin akan menghapus',
                   showCloseButton: true,
                   showCancelButton: true,
               }).then((result) => {
                   if (result.isConfirmed) {
                       this.axios.delete(`http://localhost:8000/api/product_requests/${id}`).then(response =>{
                           let i = this.productRequests.data.map(data => data.id).indexOf(id);
                           this.productRequests.data.splice(i, 1)
                       });
                   }
               }) 
                
            }
        }
    } 
</script>
