<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">Insert Product</h3>
                        <router-link class="btn btn-info btn-sm" to="/product" id="add_new">All Product</router-link></nav>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="productInsert" enctype="multipart/form-data">
                        	<div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group"><label class="small mb-1" for="inputFirstName">Product Name</label>
                                        <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter Product name" v-model="form.product_name" />
                                        <small class="text-danger" v-if="errors.product_name">{{errors.product_name[0]}}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                            <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Product Code</label>
                                <input class="form-control py-4" id="inputEmailAddress" type="text" aria-describedby="emailHelp" placeholder="Product Code" v-model="form.product_code" />
                                <small class="text-danger" v-if="errors.product_code">{{errors.product_code[0]}}</small>
                            </div>
                            </div>
                        </div>
                                <div class="form-row">
                                <div class="col-md-6">
                            <div class="form-group">
                            	<label class="small mb-1">Category</label>
                            	<select class="form-control" v-model="form.category_id">
                            		<option :value="category.id" v-for="category in categories">
                            			{{category.category_name}}
                            		</option>
                            		
                            	</select>
                            	<small class="text-danger" v-if="errors.category_id">{{errors.category_id[0]}}</small>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                            	<label class="small mb-1" for="">Supplier</label>
                                <select class="form-control" v-model="form.supplier_id">
                            		<option :value="supplier.id" v-for="supplier in suppliers">
                            			{{supplier.name}}
                            		</option>
                            	</select>
                            	<small class="text-danger" v-if="errors.supplier_id">{{errors.supplier_id[0]}}</small>
                            </div>
                            </div>
                        </div>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group"><label class="small mb-1" for="inputPassword">Root</label>
                                        <input class="form-control py-4" id="inputPassword" type="text" placeholder="Root" v-model="form.root" />
                                        <small class="text-danger" v-if="errors.root">{{errors.root[0]}}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label class="small mb-1" for="inputConfirmPassword">Buying Price</label>
                                        <input class="form-control py-4" type="text" placeholder="Enter Buying Price" v-model="form.buying_price" />
                                        <small class="text-danger" v-if="errors.buying_price">{{errors.buying_price[0]}}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"><label class="small mb-1" for="inputConfirmPassword">Selling Price</label>
                                        <input class="form-control py-4" type="text" placeholder="Enter Selling Price" v-model="form.selling_price" />
                                        <small class="text-danger" v-if="errors.selling_price">{{errors.selling_price[0]}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group"><label class="small mb-1">Buying Date</label>
                                        <input class="form-control py-4" type="date" v-model="form.buying_date" />
                                        <small class="text-danger" v-if="errors.buying_date">{{errors.buying_date[0]}}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label class="small mb-1">Quantity</label>
                                        <input class="form-control py-4" type="text" placeholder="Enter Quantity" v-model="form.product_quantity" />
                                        <small class="text-danger" v-if="errors.product_quantity">{{errors.product_quantity[0]}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                            <div class="col-md-4">
                            <div class="form-group">
                                <input type="file" class="btn btn-info" @change="onFileselected"/>
                                <small class="text-danger" v-if="errors.image">{{errors.image[0]}}</small>
                            </div>
                        </div>
                            <div class="col-md-4">
                                <div class="mx-5"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <img :src="form.image" style="height:40px; width: 40px;">
                            </div>
                            </div>
                        </div>
                             <button type="submit" class="btn btn-primary btn-block" >Add Product</button>
                            
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
            product_name: '',
            product_code: '',
            category_id: '',
            supplier_id: '',
            root: '',
            buying_price: '',
            selling_price: '',
            buying_date: '',
            image:'',
            product_quantity:'',
        },
        errors:{},
        categories:{},
        suppliers:{},
    }

},
methods:{
    onFileselected(event){
        let file=event.target.files[0];
        //console.log(file);
        if(file.size > 1048770){
            Toast.fire({
               icon: 'error',
               title: 'Image Must be less than 1Mb'
             })
        }
        else{
            let reader = new FileReader();
            reader.onload = event=>{
                this.form.image = event.target.result
                
            };
            reader.readAsDataURL(file);
        }
    },
    productInsert(){
        axios.post('/api/product/',this.form)
        .then(()=>{
            Toast.fire({
                      icon: 'success',
                      title: 'Successfully Product Added!'
                    })
            this.$router.push({name: 'product'})

        })
        .catch(error => this.errors = error.response.data.errors)
    },   
},
created(){
	axios.get('/api/category/')
	.then(({data})=>(this.categories = data))
	axios.get('/api/supplier/')
	.then(({data})=>(this.suppliers = data))
},
}
</script>

<style>
</style>
