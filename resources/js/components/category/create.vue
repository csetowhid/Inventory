<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">Insert New Category</h3>
                        <router-link class="btn btn-info btn-sm" to="/category" id="add_new">All Categories</router-link></nav>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="categoryInsert" enctype="multipart/form-data">
                                    <div class="form-group"><label class="small mb-1" for="inputFirstName">Full Name</label>
                                        <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter Category name" v-model="form.category_name" />
                                        <small class="text-danger" v-if="errors.category_name">{{errors.category_name[0]}}</small>
                                    </div>
                             <button type="submit" class="btn btn-primary btn-block">Insert</button>
                            
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    created() {
        if(!User.loggedIn()){
            this.$router.push({ name: '/'})
        }
    },
    data(){
    return {
        form:{
            category_name: '',
        },
        errors:{},
    }

},
methods:{
    categoryInsert(){
        axios.post('/api/category/',this.form)
        .then(()=>{
            Toast.fire({
                      icon: 'success',
                      title: 'Successfully Category Inserted!'
                    })
            this.$router.push({name: 'category'})

        })
        .catch(error => this.errors = error.response.data.errors)
    },   
}
}
</script>

<style>
</style>
