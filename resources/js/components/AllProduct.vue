<template>
    <div>
        <h2 class="text-center">Permintaan Barang</h2>
        <button class="btn btn-success float-right mb-2" data-toggle="modal" data-target="#productModal" data-backdrop="static" data-keyboard="false">
            <font-awesome-icon icon="plus" />
            Tambah
        </button>
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
                <tr  v-for="productRequest, index in productRequests.data" :key="index">
                    <td>{{index + currentPage}}</td>
                    <td>{{ productRequest.customer.name }}</td>
                    <td>{{ productRequest.date_product_request }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-info text-white" @click="previewProductRequest(productRequest.id)">Lihat</button>
                            <button class="btn btn-danger" @click="deleteProduct(productRequest.id)">Hapus</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <pagination align="right" :data="productRequests" @pagination-change-page="list"></pagination>

        <div id="productModal" class="modal" tabindex="-1" role="dialog" ref="productModal">
            <form @submit.prevent="addProductRequest">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white">{{ action }} Permintaan Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-0" for="nama">NIK Peminta*:</label>
                                        <v-select 
                                            :filterable="false" 
                                            :options="options" 
                                            @search="onSearch" 
                                            @input="setSelected" 
                                            v-model="selectedNIK"
                                            :disabled="action == 'Lihat'"
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
                                        <label class="mb-0" for="tanggal_permintaan">Tanggal Permintaan*:</label>
                                           <input type="date" class="form-control" v-model="orderDate" :disabled="action == 'Lihat'">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <h4>Daftar Barang</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="width: 250px;">Barang</th>
                                                <th>Lokasi</th>
                                                <th v-if="action == 'Tambah'">Tersedia</th>
                                                <th>Kuantiti</th>
                                                <th>Satuan</th>
                                                <th>Keterangan</th>
                                                <th v-if="action == 'Tambah'">Status</th>
                                                <th v-if="action == 'Tambah'" class="text-center" style="width: 5px;">*</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="productsSubmit.length > 0" v-for="(product, index) in productsSubmit" :key="index">
                                                <td scope="row">{{++index}}</td>
                                                <td>
                                                    <v-select 
                                                        v-if="action == 'Tambah'"
                                                        :filterable="false" 
                                                        :options="optionProducts" 
                                                        @search="onSearchProduct" 
                                                        @input="(product) => updateProduct(product, index)"
                                                    ></v-select>
                                                    <input v-if="action == 'Lihat'" class="form-control" type="text" v-model="productsSubmit[index-1].name" disabled="">
                                                </td>
                                                <td><input class="form-control" type="text" v-model="productsSubmit[index-1].location" disabled=""></td>
                                                <td v-if="action == 'Tambah'"><input class="form-control" type="text" v-model="productsSubmit[index-1].stock" disabled=""></td>
                                                <td><input :disabled="action == 'Lihat'" class="form-control" type="number" v-model="productsSubmit[index-1].quantity"></td>
                                                <td><input class="form-control" type="text" v-model="productsSubmit[index-1].packaging" disabled=""></td>
                                                <td><input :disabled="action == 'Lihat'" class="form-control" type="text" v-model="productsSubmit[index-1].description"></td>
                                                <td v-if="action == 'Tambah'">
                                                    <span v-html="setAvailibility(index - 1)"></span>
                                                </td>
                                                <td v-if="action == 'Tambah'">
                                                    <button type="button" @click="deleteItem(index)" class="btn rounded-circle">
                                                        <font-awesome-icon class="text-secondary" icon="times-circle" />
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr v-if="productsSubmit.length == 0">
                                                <td colspan="9" class="text-center">Tidak ada barang / barang belum ditambahkan</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-if="action == 'Tambah'" class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-success" @click="addInputProduct">
                                            <font-awesome-icon icon="plus" />
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between modal-footer">
                            <div v-if="action == 'Tambah'">
                                <p class="mb-0 font-weight-bold">Aturan:</p>
                                <ul class="pl-3">
                                    <li>NIK Peminta dan Tanggal Permintaan wajib diisi</li>
                                    <li>Barang Wajib ditambahkan minimal 1 barang, dengan status <strong>tersedia</strong></li>
                                </ul>
                            </div>
                            <div>
                                <button v-if="action == 'Tambah'" type="submit" class="btn btn-primary" :disabled="isDisabled">Proses</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ action == 'Tambah' ? 'Batal' : 'Kembali' }}</button>
                            </div>
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
    import $ from 'jquery'

    export default {
       components: {
           pagination
       },
       data() {
           return {
               action: 'Tambah',
               productRequests:[],
               currentPage: 1,
               options: [],
               optionProducts: [],
               name: '',
               departement: '',
               orderDate: '',
               idCustomer: '',
               productsSubmit: [],
               selected: {},
               selectedNIK: ''
            }
        },
        mounted() {
            this.list()
            $(this.$refs.productModal).on("hidden.bs.modal", this.hiddenModal)
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
           addInputProduct() {
               this.productsSubmit.push({location: '', quantity: 1, description: '-', productId: '', valid: false})
           },
           addProductRequest() {
               if (this.orderDate == '' || this.idCustomer == '') {
                   this.$swal('Isi terlebih dahulu tanggal dan nik')
               } else {
                   const inputPost = {
                       idCustomer: this.idCustomer,
                       orderDate: this.orderDate,
                       productSubmit: this.productsSubmit
                   }
                   this.axios.post(`http://localhost:8000/api/product_requests`, inputPost).then(response =>{
                       if (response.data == "Product Request created!") {
                           this.$swal({
                               icon: 'success',
                               text: 'Alhamdulillah Success'
                           }).then(res => {
                               if (res.isConfirmed) {
                                   // close modal 
                                   $('#productModal').modal('hide')

                                   this.clearModalData()
                               }
                           })
                       } else {
                           this.$swal('Maaf tambah data gagal')
                       }
                   })
               }
           },
           hiddenModal() {
               this.action = 'Tambah'
               this.clearModalData()
           },
           clearModalData() {
               // clear data
               this.name = ''
               this.label = ''
               this.orderDate = ''
               this.idCustomer = ''
               this.selectedNIK = ''
               this.departement = ''
               this.productsSubmit = []
           },
           previewProductRequest(id) {
               this.action = 'Lihat'
               axios.get(`http://localhost:8000/api/product_requests/detail/${id}`).then(res =>{
                   let result = res.data
                   this.orderDate = result.date_product_request.split("/").reverse().join("-")
                   this.name = result.customer.name               
                   this.departement = result.customer.departement
                   this.options = [{ label: result.customer.nik }]
                   this.selectedNIK = result.customer.nik

                   let index = 0
                   for (let prl of result.product_request_list) {
                       console.log(prl)
                       this.productsSubmit[index] = {
                           description: prl.description,
                           location: prl.product.location,
                           name: prl.product.name,
                           quantity: prl.quantity,
                           packaging: prl.product.packaging
                       }

                       index++
                   }
               })


               $('#productModal').modal('show')
           },
           deleteProduct(id){
               this.$swal({
                  title: 'Apakah Anda yakin akan menghapus',
                  text: "Anda tidak tidak dapat mengembalikannya",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Ya, hapus saja',
                  cancelButtonText: 'Tidak',
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
           }),
           onSearchProduct(search, loading) {
               if (search.length) {
                   loading(true)
                   this.searchProduct(loading, search, this)
               } 
           },
           searchProduct: _.debounce((loading, search, vm) => {
               axios.get(`http://localhost:8000/api/products?name=${search}`).then(res =>{
                   if (res) {
                       vm.optionProducts = res.data
                   }
                   loading(false)
               })
           }),
           updateProduct(product, index) {
               const indexCurrent = index - 1
               if (product) {
                   this.productsSubmit[indexCurrent].location = product.location
                   this.productsSubmit[indexCurrent].stock = product.stock
                   this.productsSubmit[indexCurrent].packaging = product.packaging
                   this.productsSubmit[indexCurrent].productId = product.id
               }
           },
           deleteItem(index) {
               const indexCurrent = index - 1
               if (indexCurrent != -1) {
                   this.productsSubmit.splice(indexCurrent, 1)
               }
           },
           setAvailibility(index) {
               let currentProduct = this.productsSubmit[index]

               if (currentProduct.stock > currentProduct.quantity) {
                   return '<span class="badge badge-success">Terpenuhi</span>'
               } else if (currentProduct.stock === 0) {
                   return '<span class="badge badge-danger">Kosong</span>'
               } else {
                   return '<span class="badge badge-danger">Tidak Terpenuhi</span>'
               }
               
           }
        },
        computed: {
            isDisabled: function() {
                let isValid = true
                if (this.productsSubmit.length > 0) {
                    for (let ps of this.productsSubmit) {
                        if (ps.stock < ps.quantity) {
                            isValid = false
                            break
                        } else if (ps.stock == 0) {
                            isValid = false
                            break
                        }
                    }
                }
                return !isValid
                    || this.idCustomer == ''
                    || this.orderDate == ''
            }
        } 
    } 
</script>
