<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">All Supplier</h3>
                        <router-link class="btn btn-info btn-sm" to="/store-supplier" id="add_new">Add Supplier</router-link></nav>
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
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Shop Name</th>
                                                <th>Photo</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr v-for="supplier in filtersearch" :key="supplier.id">
                                                <td>{{supplier.name}}</td>
                                                <td>{{supplier.email}}</td>
                                                <td>{{supplier.phone}}</td>
                                                <td>{{supplier.shopname}}</td>
                                                <td><img :src="supplier.photo" id="em_photo"></td>
                                                <td>
                                                    <router-link :to="{name: 'edit-supplier', params:{id: supplier.id}}" class="btn btn-sm btn-info">Edit</router-link>
                                                    <!-- <router-link :to="{name: 'view-supplier', params:{id: supplier.id}}" class="btn btn-sm btn-secondary">View</router-link> -->
                                                    <a @click="deleteSupplier(supplier.id)" class="btn btn-sm btn-danger">Delete</a>
                                                    
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
    data(){
        return{
            suppliers:[],
            searchTerm:''
        }
    },
    created(){
        this.allSupplier();
    },
    computed:{
        filtersearch(){
           return this.suppliers.filter(supplier=>{
           return supplier.email.match(this.searchTerm)
            })
        }
    },
    methods:{
        allSupplier(){
            axios.get('/api/supplier/')
            .then(({data})=>(this.suppliers=data))
            .catch()
        },
        deleteSupplier(id){
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
                axios.delete('/api/supplier/'+id)
                .then(()=>{
                    this.suppliers = this.suppliers.filter(supplier=>{
                        return supplier.id !=id
                    })
                })
                .catch(()=>{
                    this.$router.push({name: 'supplier'})
                })
                Swal.fire(
                  'Deleted!',
                  'Supplier Deleted.',
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
