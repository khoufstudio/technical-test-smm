<template>
    <div>
        <h2 class="text-center">Permintaan Barang</h2>
        <button class="btn btn-danger float-right mb-2" data-toggle="modal" data-target="#productModal" data-backdrop="static" data-keyboard="false">Tambah</button>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Detail</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product, index in products" :key="product.id">
                    <td>{{++index}}</td>
                    <td>{{product.name}}</td>
                    <td>{{product.detail}}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <router-link :to="{name: 'edit', params: {id: product.id}}" class="btn btn-success">Edit</router-link>
                            <button class="btn btn-danger" @click="deleteProduct(product.id)">Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

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
    export default{
       data(){
         return{
           products:[
             {id: 1, name: 'coy', detail: 'cuy'}
           ]
         }
        },
       created(){
            this.axios.get('http://localhost:8000/api/products/').then(response => {
                this.products = response.data;
             });
        },
       methods:{
           deleteProduct(id){
                this.axios.delete('http://localhost:8000/api/products/${id}').then(response =>{
                    let i=this.products.map(data=>data.id).indexOf(id);
                    this.products.splice(i, 1)
                });
            }
        }
    } 
</script>
