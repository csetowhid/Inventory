<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">All Categories</h3>
                        <router-link class="btn btn-info btn-sm" to="/store-category" id="add_new">Add Category</router-link></nav>
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
                                                <th>Category Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr v-for="category in filtersearch" :key="category.id">
                                                <td>{{category.category_name}}</td>
                                                <td>
                                                    <router-link :to="{name: 'edit-category', params:{id: category.id}}" class="btn btn-sm btn-info">Edit</router-link>
                                                    <!-- <router-link :to="{name: 'view-supplier', params:{id: supplier.id}}" class="btn btn-sm btn-secondary">View</router-link> -->
                                                    <a @click="deleteCategory(category.id)" class="btn btn-sm btn-danger">Delete</a>
                                                    
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
            categories:[],
            searchTerm:''
        }
    },
    created(){
        this.allCategory();
    },
    computed:{
        filtersearch(){
           return this.categories.filter(category=>{
           return category.category_name.match(this.searchTerm)
            })
        }
    },
    methods:{
        allCategory(){
            axios.get('/api/category/')
            .then(({data})=>(this.categories=data))
            .catch()
        },
        deleteCategory(id){
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
                axios.delete('/api/category/'+id)
                .then(()=>{
                    this.categories = this.categories.filter(category=>{
                        return category.id !=id
                    })
                })
                .catch(()=>{
                    this.$router.push({name: 'category'})
                })
                Swal.fire(
                  'Deleted!',
                  'Category Deleted.',
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
