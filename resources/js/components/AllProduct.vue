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
                            <router-link :to="{name: 'edit', params: {id: productRequest.id}}" class="btn btn-primary">Edit</router-link>
                            <button class="btn btn-danger" @click="deleteProduct(productRequest.id)">Hapus</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <pagination align="right" :data="productRequests" @pagination-change-page="list"></pagination>

        <div id="productModal" class="modal" tabindex="-1" role="dialog">
            <form @submit.prevent="addProductRequest">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white">Tambah Permintaan Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-0" for="nama">NIK Peminta:</label>
                                        <v-select 
                                            :filterable="false" 
                                            :options="options" 
                                            @search="onSearch" 
                                            @input="setSelected" 
                                        ></v-select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-0" for="nama">Nama:</label>
                                        <input type="text" class="form-control" placeholder="Nama" id="nama" disabled="" v-model="name">
                                    </div>
                                </div>                                
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-0" for="departemen">Departemen:</label>
                                        <input type="text" class="form-control" placeholder="Departemen" id="departemen" disabled="" v-model="departement">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="mb-0" for="tanggal_permintaan">Tanggal Permintaan:</label>
                                       <input type="date" class="form-control" v-model="orderDate">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Barang</th>
                                                <th scope="col">Lokasi</th>
                                                <th scope="col">Tersedia</th>
                                                <th scope="col">Kuantiti</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">*</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                                <td>@mdo</td>
                                                <td>@mdo</td>
                                                <td>@mdo</td>
                                                <td>@mdo</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Proses</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import pagination from 'laravel-vue-pagination'
    import _ from 'lodash'

    export default {
       components: {
           pagination
       },
       data(){
         return{
           productRequests:[],
           currentPage: 1,
           options: [],
           name: '',
           departement: '',
           orderDate: '',
           idCustomer: ''
         }
        },
        mounted() {
            this.list()
        },

        methods: {
           async list(page = 1) {
              await axios.get(`http://localhost:8000/api/product_requests?page=${page}`).then(({data})=> {
                 this.productRequests = data
                 this.currentPage = page > 1 ? (page-1) * 5 + 1 : page
              }).catch(({ response })=>{
                 console.error(response)
              })
           },
           addProductRequest() {
               if (this.orderDate == '' || this.idCustomer == '') {
                   this.$swal('Isi terlebih dahulu tanggal dan nik')
               } else {
                   const inputPost = {
                       idCustomer: this.idCustomer,
                       orderDate: this.orderDate
                   }
                   this.axios.post(`http://localhost:8000/api/product_requests`, inputPost).then(response =>{
                       if (response.data == "Product Request created!") {
                           this.$swal('Alhamdulillah Success')
                       }
                   })
               }
           },
           deleteProduct(id){
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
           },
           setSelected(event) {
               if (event) {
                   this.name = event.name
                   this.departement = event.departement
                   this.idCustomer = event.id
               } else {
                   this.name = ''
                   this.departement = ''
                   this.idCustomer = ''
               }
           },
           onSearch(search, loading) {
               if (search.length) {
                   loading(true)
                   this.search(loading, search, this)
               } 
           },
           search: _.debounce((loading, search, vm) => {
               axios.get(`http://localhost:8000/api/customer/nik/${search}`).then(res =>{
                   if (res) {
                       vm.options = res.data
                   }
                   loading(false)
               })
           })
        },
    } 
</script>
