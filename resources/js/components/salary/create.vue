<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">Employee Salary</h3>
                        <router-link class="btn btn-info btn-sm" to="/salary" id="add_new">All Salary</router-link></nav>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="salarypaid">
                                    <div class="form-group"><label class="small mb-1" for="inputFirstName">Full Name</label>

                                    <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter Your name" v-model="form.name" />
                                        <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                    </div>
                            <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Email</label>
                                <input class="form-control py-4" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Enter email address" v-model="form.email" />
                                <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                            <div class="form-group">
                            	<label class="small mb-1">Month</label>
                            	<select class="form-control" v-model="form.salary_month">
                            	<option value="January">January</option>
                            	<option value="February">February</option>
                            	<option value="March">March</option>
                            	<option value="April">April</option>
                            	<option value="May">May</option>
                            	<option value="June">June</option>
                            	<option value="July">July</option>
                            	<option value="August">August</option>
                            	<option value="September">September</option>
                            	<option value="October">October</option>
                            	<option value="November">November</option>
                            	<option value="December">December</option>
                            	</select>
                            	<small class="text-danger" v-if="errors.salary_month">{{errors.salary_month[0]}}</small>
                            </div>
                            </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label class="small mb-1" for="inputConfirmPassword">Salary</label>
                                        <input class="form-control py-4" type="text" placeholder="Salary" v-model="form.salary" />
                                        <small class="text-danger" v-if="errors.salary">{{errors.salary[0]}}</small>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" >Pay</button>
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
            name: '',
            email: '',
            salary: '',
            salary_month:'',
        },
        errors:{},
    }

},
created(){
	let id = this.$route.params.id
	axios.get('/api/employee/'+id)
	.then(({data})=>(this.form = data))
	.catch(console.log('error'))
},
methods:{
    salarypaid(){
    	let id = this.$route.params.id
        axios.post('/api/salary/paid/'+id,this.form)
        .then(()=>{
            Toast.fire({
                      icon: 'success',
                      title: 'Successfully Salary Paid!'
                    })
            this.$router.push({name: 'given-salary'})

        })
        .catch(error => this.errors = error.response.data.errors)
    },   
}
}
</script>

<style>
</style>
