<template>
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-2">Employee Update</h3>
                        <router-link class="btn btn-info btn-sm" to="/employee" id="add_new">Employee Update</router-link></nav>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="employeeUpdate" enctype="multipart/form-data">
                                    <div class="form-group"><label class="small mb-1" for="inputFirstName">Full Name</label>

                                        <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter Your name" v-model="form.name" />
                                        <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                                    </div>
                                    <div class="form-row">
                                <div class="col-md-6">
                            <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Email</label>

                                <input class="form-control py-4" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Enter email address" v-model="form.email" />
                                <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group"><label class="small mb-1" for="">Phone</label>
                                <input class="form-control py-4" id="inputEmailAddress" type="number"  placeholder="Enter Phone Number" v-model="form.phone" />
                                <small class="text-danger" v-if="errors.phone">{{errors.phone[0]}}</small>
                            </div>
                            </div>
                        </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group"><label class="small mb-1" for="inputPassword">Address</label>

                                        <input class="form-control py-4" id="inputPassword" type="text" placeholder="Address" v-model="form.address" />
                                        <small class="text-danger" v-if="errors.address">{{errors.address[0]}}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label class="small mb-1" for="inputConfirmPassword">Salary</label>
                                        <input class="form-control py-4" type="text" placeholder="Salary" v-model="form.salary" />
                                        <small class="text-danger" v-if="errors.salary">{{errors.salary[0]}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group"><label class="small mb-1" for="inputPassword">Joining Date</label>
                                        <input class="form-control py-4" id="inputdate" type="date" v-model="form.joining_date" />
                                        <small class="text-danger" v-if="errors.joining_date">{{errors.joining_date[0]}}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><label class="small mb-1" for="nid">Nid Number</label>
                                        <input class="form-control py-4" type="text" placeholder="National Id Number" v-model="form.nid" />
                                        <small class="text-danger" v-if="errors.nid">{{errors.nid[0]}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                            <div class="col-md-4">
                            <div class="form-group">
                                <input type="file" class="btn btn-info" @change="onFileselected"/>
                                <small class="text-danger" v-if="errors.photo">{{errors.photo[0]}}</small>
                            </div>
                        </div>
                            <div class="col-md-4">
                                <div class="mx-5"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <img :src="form.photo" style="height:40px; width: 40px;">
                            </div>
                            </div>
                        </div>
                             <button type="submit" class="btn btn-primary btn-block" >Update</button>
                            
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
            address: '',
            photo: '',
            newphoto: '',
            phone: '',
            nid: '',
            joining_date: '',
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
    onFileselected(event){
        let file=event.target.files[0];
        //console.log(file);
        if(file.size > 1048770){
            Toast.fire({
               icon: 'error',
               title: 'Image Must be less than 1Mb'
             })
        }
        else{
            let reader = new FileReader();
            reader.onload = event=>{
                this.form.newphoto = event.target.result
                //console.log(event.target.result);
            };
            reader.readAsDataURL(file);
        }
    },
    employeeUpdate(){
    	let id = this.$route.params.id
        axios.patch('/api/employee/'+id,this.form)
        .then(()=>{
            Toast.fire({
                      icon: 'success',
                      title: 'Successfully Employee Updated!'
                    })
            this.$router.push({name: 'employee'})

        })
        .catch(error => this.errors = error.response.data.errors)
    },   
}
}
</script>

<style>
</style>
