<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                    	<h3 class="text-center font-weight-light my-2">Search Order</h3>
                        <router-link class="btn btn-info btn-sm" to="/order" id="add_new">Today Order</router-link>
                    </div>
                    <div class="row">
                    	<div class="col-lg-6">
                    		<div class="card-body">
                    		<form @submit.prevent="searchDate" enctype="multipart/form-data">
                                    <div class="form-group"><label class="small mb-1" for="inputFirstName">Search By Date</label>
                                        <input class="form-control py-4" type="date" placeholder="Enter Date" v-model="date" required />
                                        
                                    </div>
                             <button type="submit" class="btn btn-primary btn-block">Search</button>
                            
                        </form>
                    </div>
                    	</div>
                    	<div class="col-lg-6">
                    		<div class="card-body">
                    		<form @submit.prevent="searchMonth" enctype="multipart/form-data">
                                    <div class="form-group"><label class="small mb-1" for="inputFirstName">Search By Month</label>
                                        <select class="form-control" v-model="month" required>
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
                                    </div>
                             <button type="submit" class="btn btn-primary btn-block">Search</button>
                            
                        </form>
                    </div>
                    	</div>
                    </div>
                <div class="card-body">
                       <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                                <li class="list-group-item bg-info text-white">Order Details</li>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="" width="100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Vat</th>
                                        <th>Pay</th>
                                        <th>Due</th>
                                        <th>Sub Total</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="order in orders">
                                        <td>{{ order.name}}</td>
                                        <td>{{ order.qty}}</td>
                                        <td>{{ order.vat}}</td>
                                        <td>{{ order.pay}}</td>
                                        <td>{{ order.due}}</td>
                                        <td>{{ order.sub_total}}</td>
                                        <td>{{ order.total}}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td>{{quantity}} Piece</td>
                                        <td></td>
                                        <td>{{Pay}}</td>
                                        <td>{{Due}}</td>
                                        <td>{{subtotal}}</td>
                                        <td>{{Total}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
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
        if(!User.loggedIn()){
            this.$router.push({ name: '/'})
        }
    },
    data(){
    return {
        
            date: '',
            month: '',
            orders:{},
            errors:{},
    }

},
    computed:{
        quantity(){
            let sum=0;
            for(let i=0;i<this.orders.length;i++){
                sum += (parseFloat(this.orders[i].qty));
            }
            return sum;
        },
        subtotal(){
            let sum=0;
            for(let i=0;i<this.orders.length;i++){
                sum += (parseFloat(this.orders[i].sub_total));
            }
            return sum;
        },
        Total(){
            let sum=0;
            for(let i=0;i<this.orders.length;i++){
                sum += (parseFloat(this.orders[i].total));
            }
            return sum;
        },
        Pay(){
            let sum=0;
            for(let i=0;i<this.orders.length;i++){
                sum += (parseFloat(this.orders[i].pay));
            }
            return sum;
        },
        Due(){
            let sum=0;
            for(let i=0;i<this.orders.length;i++){
                sum += (parseFloat(this.orders[i].due));
            }
            return sum;
        },
    },
methods:{
    searchDate(){
        let data = {date:this.date}
        axios.post('/api/search/order',data)
        .then(({data})=>(this.orders = data))
        .catch(error => this.errors = error.response.data.errors)
    }, 
      searchMonth(){
        axios.post('/api/search/month',this.form)
        .then(()=>{
            
        })
        .catch(error => this.errors = error.response.data.errors)
    }, 
}
}
</script>

<style>
</style>
