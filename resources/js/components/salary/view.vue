<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">Employee Salary Details</h3>
                        <router-link class="btn btn-info btn-sm" to="/salary" id="add_new">All Salary</router-link></nav>
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
                                                <th>Month</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr v-for="salary in filtersearch" :key="salary.id">
                                                <td>{{salary.name}}</td>
                                                <td>{{salary.salary_month}}</td>
                                                <td>{{salary.amount}}</td>
                                                <td>{{salary.salary_date}}</td>
                                                <td>
                                                    <router-link :to="{name: 'edit-salary', params:{id: salary.id}}" class="btn btn-sm btn-info">Edit Salary</router-link>
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
            salaries:[],
            searchTerm:''
        }
    },
    computed:{
        filtersearch(){
           return this.salaries.filter(salary=>{
                return salary.name.match(this.searchTerm)
            })
        }
    },
    methods:{
        viewSalary(){
        let id = this.$route.params.id
        axios.get('/api/salary/view/'+id)
		.then(({data})=>(this.salaries=data))
        .catch(error => this.errors = error.response.data.errors)
        },
    },
    created(){
        this.viewSalary();
    }
}
</script>

<style>
#em_photo{
    width:50px;
}
</style>
