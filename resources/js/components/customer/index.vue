<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">All Customer</h3>
                        <router-link class="btn btn-info btn-sm" to="/store-customer" id="add_new">Add Customer</router-link></nav>
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
                                                <th>Address</th>
                                                
                                                <th>Photo</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr v-for="customer in filtersearch" :key="customer.id">
                                                <td>{{customer.name}}</td>
                                                <td>{{customer.email}}</td>
                                                <td>{{customer.phone}}</td>
                                                <td>{{customer.address}}</td>
                                                
                                                <td><img :src="customer.photo" id="em_photo"></td>
                                                <td>
                                                    <router-link :to="{name: 'edit-customer', params:{id: customer.id}}" class="btn btn-sm btn-info">Edit</router-link>
                                                    
                                                    <a @click="deleteCustomer(customer.id)" class="btn btn-sm btn-danger">Delete</a>
                                                    
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
            customers:[],
            searchTerm:''
        }
    },
    computed:{
        filtersearch(){
           return this.customers.filter(customer=>{
                return customer.phone.match(this.searchTerm)
            })
        }
    },
    methods:{
        allCustomer(){
            axios.get('/api/customer/')
            .then(({data})=>(this.customers=data))
            .catch()
        },
        deleteCustomer(id){
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
                axios.delete('/api/customer/'+id)
                .then(()=>{
                    this.customers = this.customers.filter(customer=>{
                        return customer.id !=id
                    })
                })
                .catch(()=>{
                    this.$router.push({name: 'customer'})
                })
                Swal.fire(
                  'Deleted!',
                  'Customer Deleted.',
                  'success'
                )
              }
            })
        }
    },
    created(){
        this.allCustomer();
    }
}
</script>

<style>
#em_photo{
    width:50px;
}
</style>
