<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">All Employee</h3>
                        <router-link class="btn btn-info btn-sm" to="/store-employee" id="add_new">Add Employee</router-link></nav>
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
                                                <th>Joining Date</th>
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
                                                <td>{{employee.joining_date}}</td>
                                                <td><img :src="employee.photo" id="em_photo"></td>
                                                <td>
                                                    <router-link :to="{name: 'edit-employee', params:{id: employee.id}}" class="btn btn-sm btn-info">Edit</router-link>
                                                    <router-link :to="{name: 'view-employee', params:{id: employee.id}}" class="btn btn-sm btn-secondary">View</router-link>
                                                    <a @click="deleteEmployee(employee.id)" class="btn btn-sm btn-danger">Delete</a>
                                                    
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
        deleteEmployee(id){
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
                axios.delete('/api/employee/'+id)
                .then(()=>{
                    this.employees = this.employees.filter(employee=>{
                        return employee.id !=id
                    })
                })
                .catch(()=>{
                    this.$router.push({name: 'employee'})
                })
                Swal.fire(
                  'Deleted!',
                  'Employee Deleted.',
                  'success'
                )
              }
            })
        }
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
