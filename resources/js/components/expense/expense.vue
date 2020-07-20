<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">All Expense</h3>
                        <router-link class="btn btn-info btn-sm" to="/store-expense" id="add_new">Add New Expense</router-link></nav>
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
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr v-for="expense in filtersearch" :key="expense.id">
                                                <td>{{expense.details}}</td>
                                                <td>{{expense.amount}}</td>
                                                <td>{{expense.expense_date}}</td>
                                                <td>
                                                    <router-link :to="{name: 'edit-expense', params:{id: expense.id}}" class="btn btn-sm btn-info">Edit</router-link>
                                                    <!-- <router-link :to="{name: 'view-supplier', params:{id: supplier.id}}" class="btn btn-sm btn-secondary">View</router-link> -->
                                                    <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger">Delete</a>
                                                    
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
            expenses:[],
            searchTerm:'',
        }
    },
    created(){
        this.allExpense();
    },
    computed:{
        filtersearch(){
           return this.expenses.filter(expense=>{
           return expense.expense_date.match(this.searchTerm)
            })
        }
    },
    methods:{
        allExpense(){
            axios.get('/api/expense/')
            .then(({data})=>(this.expenses=data))
            .catch()
        },
        deleteExpense(id){
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
                axios.delete('/api/expense/'+id)
                .then(()=>{
                    this.expenses = this.expenses.filter(expense=>{
                        return expense.id !=id
                    })
                })
                .catch(()=>{
                    this.$router.push({name: 'expense'})
                })
                Swal.fire(
                  'Deleted!',
                  'Expense Deleted.',
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
