<template>
   <div class="container center">
    <div id="address" class="bg-light p-4 rounded">
        <h1 class="mb-4">Shipping Address</h1>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" v-model="name">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" v-model="phone">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea v-model="address" class="form-control" id="address" cols="30" rows="10" placeholder="Name&#10;House no.&#10;Village/Street&#10;City"></textarea>
        </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-success" @click.prevent="storeAddress">
        </div>       
    </div>
</div>
</template>
<script>
import axios from 'axios';
import { useRouter } from 'vue-router';
export default{
    data(){
        return{
            name:'',
            phone:'',
            address:'',
        }
    },
    methods:{
        storeAddress(){
            let payload = {
                name : this.name,
                order_id: localStorage.getItem('order_id'),
                phone: this.phone,
                address: this.address
            }
            axios.post('customer_address', payload)
            .then(response=>{
                alert(response.data)
                const router = useRouter()
                this.$router.push('/customer_invoice')
            })
            .catch(errors=>{
                console.log(errors.message)
            })
        }
    }
}
</script>