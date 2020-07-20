<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">Order Details</h3>
                        <router-link class="btn btn-info btn-sm" to="/order" id="add_new">Today Order</router-link></nav>
                    </div>
                    
                    <div class="card-body">
                       <div class="row">
                       	<div class="col-lg-12 col-md-12 col-12">
                       			<li class="list-group-item bg-info text-white">Customer Details</li>
                       	</div>
                <div class="col-lg-6 col-md-6 col-6">
                    <ul class="list-group">
                       	<br>
                       	<li class="list-group-item">Name : {{orders.name}}</li>
                       	<li class="list-group-item">Phone : {{orders.phone}}</li>
                       	<li class="list-group-item">Address : {{orders.address}}</li>
                       	<li class="list-group-item">Date : {{orders.order_date}}</li>
                       	<li class="list-group-item">Sub Total : {{orders.sub_total}}</li>
                       	<li class="list-group-item">Total : {{orders.toal}}</li>
                       	</ul>
                       	</div>
                <div class="col-lg-6 col-md-6 col-6">
                    <ul class="list-group">
                       	<br>									
                       	<li class="list-group-item">Vat : {{orders.vat}}</li>
                       	<li class="list-group-item">Quantity : {{orders.qty}}</li>
                       	<li class="list-group-item">Pay : {{orders.pay}}</li>
                       	<li class="list-group-item">Due : {{orders.due}}</li>
                       	<li class="list-group-item">Pay By : {{orders.payby}}</li>
                    </ul>
                       	</div>
                       </div>
                    </div>
                    <br>
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
                       					<th>Code</th>
                       					<th>Image</th>
                       					<th>Quantity</th>
                       					<th>Unit Price</th>
                       					<th>Total</th>
                       				</tr>
                       			</thead>
                       			<tbody>
                       				<tr v-for="detail in details">
                       					<td>{{ detail.product_name}}</td>
                       					<td>{{ detail.product_code}}</td>
                       					<td><img :src="'/'+detail.image" id="em_photo"></td>
                       					<td>{{ detail.pro_quantity}}</td>
                       					<td>{{ detail.product_price}}</td>
                       					<td>{{ detail.sub_total}}</td>
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
        errors:{},
        orders:{},
        details:{},
    }

},
created(){
	let id = this.$route.params.id
	axios.get('/api/order/details/'+id)
	.then(({data})=>(this.orders = data))
	.catch(console.log('error'))

	axios.get('/api/order/orderdetails/'+id)
	.then(({data})=>(this.details = data))
	.catch(console.log('error'))
	
},
methods:{
  
}
}
</script>

<style>
#em_photo{
    width:50px;
}
</style>
