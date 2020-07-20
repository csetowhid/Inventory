<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">All Product</h3>
                        <router-link class="btn btn-info btn-sm" to="/store-product" id="add_new">Add Product</router-link></nav>
                    </div>
                        <div class="card-body">
                                <div class="table-responsive">
                                    <div class="col-lg-3 my-2">
                                    <label>Search</label>
                                    <input type="text" v-model="searchTerm" class="form-control">
                                    </div>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Code</th>
                                                <th>Category</th>
                                                <th>Buying Price</th>
                                                <th>Selling Date</th>
                                                <th>Root</th>
                                                <th>Photo</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr v-for="product in filtersearch" :key="product.id">
                                                <td>{{product.product_name}}</td>
                                                <td>{{product.product_code}}</td>
                                                <td>{{product.category_name}}</td>
                                                <td>{{product.buying_price}}</td>
                                                <td>{{product.selling_price}}</td>
                                                <td>{{product.root}}</td>
                                                <td><img :src="product.image" id="em_photo"></td>
                                                <td>
                                                    <router-link :to="{name: 'edit-product', params:{id: product.id}}" class="btn btn-sm btn-info">Edit</router-link>
                                                    <!-- <router-link :to="{name: 'view-product', params:{id: product.id}}" class="btn btn-sm btn-secondary">View</router-link> -->
                                                    <a @click="deleteProduct(product.id)" class="btn btn-sm btn-danger">Delete</a>
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    mounted() {
        if(!User.loggedIn()){
            this.$router.push({ name: '/'})
        }
    },
    created(){
        this.allProduct();
    },
    data(){
        return{
            products:[],
            searchTerm:''
        }
    },
    computed:{
        filtersearch(){
           return this.products.filter(product=>{
                return product.product_name.match(this.searchTerm)
            })
        }
    },
    methods:{
        allProduct(){
            axios.get('/api/product/')
            .then(({data})=>(this.products=data))
            .catch()
        },
        deleteProduct(id){
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                axios.delete('/api/product/'+id)
                .then(()=>{
                    this.products = this.products.filter(product=>{
                        return product.id !=id
                    })
                })
                .catch(()=>{
                    this.$router.push({name: 'product'})
                })
                Swal.fire(
                  'Deleted!',
                  'Product Deleted.',
                  'success'
                )
              }
            })
        }
    },
    
}
</script>

<style>
#em_photo{
    width:50px;
}
</style>
