<template>
  <div class="justify-center w-4/5 mt-4 mx-auto divide-y divide-gray-200">
    <form
            class="bg-white w-full shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="title" v-model="title" type="text" placeholder="Enter your title">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                    Price
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="price" v-model="price" type="text" placeholder="Enter your price">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="old_price">
                    Old Price
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="old_price" v-model="old_price" type="text" placeholder="Enter your old_price">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    v-model="description" id="" cols="30" rows="10"></textarea>
            </div>
            <!-- <div id="dropzone" class="dropzone"></div> -->
            <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Media</h6>
                    </div>
                    <div class="card-body border">
                        <!-- Example of a form that Dropzone can take over -->
                        <div id="myId" ref="imageDropzone" class="dropzone"></div>
                    </div>
                </div>
            <div class="mb-4">
            <select v-model="category_id"
                class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
            </div>
            <div class="mb-4">
                <select v-model="unit"
                    class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="pc">PC</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button @click.prevent="saveProductInfo"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Create
                </button>
            </div>
        </form>
  </div>
</template>

<script>
import { onMounted } from 'vue';
import { Dropzone } from 'dropzone';
import { useRouter } from 'vue-router';
import axios from 'axios';
export default {
    setup() {
    onMounted(() => {
      const dropzone = new Dropzone('div#myId', {
        url: '/file/post', // URL for uploading files
        maxFilesize: 2, // Maximum file size in megabytes
        addRemoveLinks: true, // Show remove links for uploaded files
        autoProcessQueue: false,
      });

      // You can add event listeners or handle events here if needed
      dropzone.on('success', (file, response) => {
        console.log('File uploaded:', file);
        console.log('Server response:', response);
      });

      dropzone.on('error', (file, errorMessage, xhr) => {
        console.error('Error uploading file:', errorMessage);
      });
    });

    return {};
  // Rest of your code...
  },
  data(){
    return {
        title:'',
        price:'',
        old_price:'',
        description:'',
        category_id:'',
        categories:'',
        unit:''
    }
  },
  mounted(){
    this.showCat()
  },
  methods:{
    async saveProductInfo(){
      const formData = new FormData()
      let dropzone = this.$refs.imageDropzone.dropzone;
            let files = dropzone.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i]
                formData.append('images[]', file)
            }
      let productsData = {
        title: this.title,
        price:this.price,
        old_price: this.old_price,
        description: this.description,
        category_id: this.category_id,
        unit:this.unit,
      }

      formData.append('productsData', JSON.stringify(productsData));

      const router = useRouter()
      await axios.post('/product', formData).then(response => {
                console.log(response.data)
                this.$router.push('/allProduct');
            }).catch(error => {
                console.log(this.errors);
            })
    },
    
  async showCat(){
    await axios.get('/category'). 
      then(response=>{
        this.categories = response.data 
      }).catch(error=>{
        console.log(error)
      })
  }
  },
};
</script>
<style>
  .dz-progress{
    display: none!important;
  }
</style>








