<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">All Salary Details</h3>
                        <router-link class="btn btn-info btn-sm" to="/given-salary" id="add_new">Employee Salary</router-link></nav>
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
                                                <th>Month Name</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr v-for="salary in filtersearch" :key="salary.id">
                                                <td>{{salary.salary_month}}</td>
                                                <td>
                                                    <router-link :to="{name: 'view-salary', params:{id: salary.salary_month}}" class="btn btn-sm btn-info">View Salary</router-link>
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
        this.allSalary();
    },
    data(){
        return{
            salaries:[],
            searchTerm:''
        }
    },
    computed:{
        filtersearch(){
           return this.salaries.filter(salary => {
                return salary.salary_month.match(this.searchTerm)
            })
        }
    },
    methods:{
        allSalary(){
            axios.get('/api/salary/')
            .then(({data})=>(this.salaries=data))
            .catch()
        },
    },
    
}
</script>

<style>
#em_photo{
    width:50px;
}
</style>
