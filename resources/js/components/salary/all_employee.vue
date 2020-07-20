<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">Employee Salary Pay</h3>
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
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Salary</th>
                                               
                                                <th>Photo</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr v-for="employee in filtersearch" :key="employee.id">
                                                <td>{{employee.name}}</td>
                                                <td>{{employee.email}}</td>
                                                <td>{{employee.phone}}</td>
                                                <td>{{employee.salary}}</td>
                                                
                                                <td><img :src="employee.photo" id="em_photo"></td>
                                                <td>
                                                    <router-link :to="{name: 'pay-salary', params:{id: employee.id}}" class="btn btn-sm btn-info">Pay Salary</router-link>
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
            employees:[],
            searchTerm:''
        }
    },
    computed:{
        filtersearch(){
           return this.employees.filter(employee=>{
                return employee.email.match(this.searchTerm)
            })
        }
    },
    methods:{
        allEmployee(){
            axios.get('/api/employee/')
            .then(({data})=>(this.employees=data))
            .catch()
        },
    },
    created(){
        this.allEmployee();
    }
}
</script>

<style>
#em_photo{
    width:50px;
}
</style>
