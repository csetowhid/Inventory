<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">Product Update</h3>
                        
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="stockUpdate">
                        	<div class="form-group"><label class="small mb-1" for="inputFirstName">Product Name</label>
                                        <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter Product name" v-model="form.product_name" />
                                        <small class="text-danger" v-if="errors.product_name">{{errors.product_name[0]}}</small>
                                    </div>

                                    <div class="form-group"><label class="small mb-1" for="inputFirstName">Quantity</label>
                                        <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter Product Quantity" v-model="form.product_quantity" />
                                        <small class="text-danger" v-if="errors.product_quantity">{{errors.product_quantity[0]}}</small>
                                    </div>
                                
                            	
                          
                             <button type="submit" class="btn btn-primary btn-block" >Stock Update</button>
                            
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
    mounted() {
        if(!User.loggedIn()){
            this.$router.push({ name: '/'})
        }
    },
    data(){
    return {
        form:{
        	product_name: '',
            product_quantity:'',
        },
        errors:{},
        
    }

},
created(){
	let id = this.$route.params.id
	axios.get('/api/product/'+id)
	.then(({data})=>(this.form = data))
	.catch()
	
},
methods:{
    stockUpdate(){
    	let id = this.$route.params.id
        axios.post('/api/stock/update/'+id,this.form)
        .then(()=>{
            Toast.fire({
                      icon: 'success',
                      title: 'Successfully Stock Updated!'
                    })
            this.$router.push({name: 'stock'})

        })
        .catch(error => this.errors = error.response.data.errors)
    },   
}
}
</script>

<style>
</style>
