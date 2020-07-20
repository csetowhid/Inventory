<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">Today Order</h3>
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
                                                <th>Total Amount</th>
                                                <th>Pay</th>
                                                <th>Due</th>
                                                <th>Pay By</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr v-for="order in filtersearch" :key="order.id">
                                                <td>{{order.name}}</td>
                                                <td>{{order.total}}</td>
                                                <td>{{order.pay}}</td>
                                                <td>{{order.due}}</td>
                                                <td>{{order.payby}}</td>
                                                <td>
                                                    <router-link :to="{name: 'view-order', params:{id: order.id}}" class="btn btn-sm btn-info">View</router-link>
                                                   
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
            orders:[],
            searchTerm:'',
        }
    },
    created(){
        this.allOrder();
    },
    computed:{
        filtersearch(){
           return this.orders.filter(order => {
           return order.name.match(this.searchTerm)
            })
        }
    },
    methods:{
        allOrder(){
            axios.get('/api/orders/')
            .then(({data}) => (this.orders = data))
            .catch()
        },
    },
    
}
</script>

<style>
</style>
