<template>
    <div>
        <div class="container-fluid">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Today Sell</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            {{todaysell}} Tk
                            
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Today Income</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            {{income}} Tk
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Today Due</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            {{due}} Tk
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Today Expense</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            {{expense}} Tk
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-chart-area mr-1"></i>Stock Out Products</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Code</th>
                                                <th>Buying Price</th>
                                                <th>Status</th>
                                                <th>Quantity</th>
                                                <th>Photo</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr v-for="product in products" :key="product.id">
                                                <td>{{product.product_name}}</td>
                                                <td>{{product.product_code}}</td>
                                                
                                                <td>{{product.buying_price}}</td>

 <td v-if="product.product_quantity >=1"><span class="badge badge-success">Available</span></td>
 <td v-else=""><span class="badge badge-danger">Stock Out</span></td>

                                                <td>{{product.product_quantity}}</td>
                                                <td><img :src="product.image" id="em_photo"></td>
                                                
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
        created() {
            if (!User.loggedIn()) {
                 this.$router.push({
                     name: '/'
                 })
             }
        },
        data(){
            return {
            todaysell:'',
            income:'',
            expense:'',
            due:'',
            products:''
            }
        },
        mounted(){
            this.TodaySell();
            this.TodayIncome();
            this.TodayDue();
            this.TodayExpense();
            this.StockOut();
        },
        methods:{
            TodaySell(){
            axios.get('/api/today/sell')
            .then(({data})=>(this.todaysell = data))
            .catch()
            },
            TodayIncome(){
            axios.get('/api/today/income')
            .then(({data})=>(this.income = data))
            .catch()
            },
            TodayDue(){
            axios.get('/api/today/due')
            .then(({data})=>(this.due = data))
            .catch()
            },
            TodayExpense(){
            axios.get('/api/today/expense')
            .then(({data})=>(this.expense = data))
            .catch()
            },
            StockOut(){
                axios.get('/api/today/stockout')
            .then(({data})=>(this.products = data))
            .catch()
            }
        }
    }
</script>
<style>
</style>
