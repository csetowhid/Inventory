<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">Expense Update</h3>
                        <router-link class="btn btn-info btn-sm" to="/expense" id="add_new">All Expense</router-link></nav>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="expenseUpdate" >
                        	<div class="form-group"><label class="small mb-1">Expense Details</label>
                                        <textarea class="form-control" rows="3" v-model="form.details"></textarea>
                                        
                                        <small class="text-danger" v-if="errors.details">{{errors.details[0]}}</small>
                                    </div>
                                    <div class="form-group"><label class="small mb-1" for="inputFirstName">Amount</label>
                                        <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter Amount" v-model="form.amount" />
                                        <small class="text-danger" v-if="errors.amount">{{errors.amount[0]}}</small>
                                    </div>
                             <button type="submit" class="btn btn-primary btn-block">Update</button>
                            
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
            details: '',
            amount:'',
        },
        errors:{},
    }

},
created(){
	let id = this.$route.params.id
	axios.get('/api/expense/'+id)
	.then(({data})=>(this.form = data))
	.catch()
},
methods:{
    expenseUpdate(){
    	let id = this.$route.params.id
        axios.patch('/api/expense/'+id,this.form)
        .then(()=>{
            Toast.fire({
                      icon: 'success',
                      title: 'Successfully Expense Updated!'
                    })
            this.$router.push({name: 'expense'})

        })
        .catch(error => this.errors = error.response.data.errors)
    },   
}
}
</script>

<style>
</style>
