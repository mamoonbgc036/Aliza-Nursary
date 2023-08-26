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
                      id="title" v-model="productData.title" type="text" placeholder="Enter your title">
              </div>
              <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                      Price
                  </label>
                  <input
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="price" v-model="productData.price" type="text" placeholder="Enter your price">
              </div>
              <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2" for="old_price">
                      Old Price
                  </label>
                  <input
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="old_price" v-model="productData.old_price" type="text" placeholder="Enter your old_price">
              </div>
              <div class="mb-6">
                  <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                      Description
                  </label>
                  <textarea
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      v-model="productData.description" id="" cols="30" rows="10"></textarea>
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
              <select v-model="productData.category_id"
                  class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                  <option v-for="category in categories" :key="category.id" :value="category.id" :selected="category.id === productData.category_id">{{ category.name }}</option>
              </select>
              </div>
              <div class="mb-4">
                  <select v-model="unit"
                      class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                      <option value="pc">PC</option>
                  </select>
              </div>
              <div class="flex items-center justify-between">
                  <button @click.prevent="updateProductInfo"
                      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                      type="submit">
                      Update
                  </button>
              </div>
          </form>
    </div>
  </template>
  
  <script>
  import { Dropzone } from 'dropzone';
  import { useRouter } from 'vue-router';
  import axios from 'axios';
  export default {
    data(){
      return {
          productData : '',
          categories: ''
      }
    },
    mounted(){
      const dropzone = new Dropzone('div#myId', {
          url: '/file/post', // URL for uploading files
          maxFilesize: 2, // Maximum file size in megabytes
          addRemoveLinks: true, // Show remove links for uploaded files
          autoProcessQueue: false,
        })
      this.getProductDataForUpdate(dropzone)
      this.showCat()
    },
    methods:{
      async updateProductInfo(){
        const formData = new FormData()
        let dropzone = this.$refs.imageDropzone.dropzone;
              let files = dropzone.files;
              for (let i = 0; i < files.length; i++) {
                  const file = files[i]
                  formData.append('images[]', file)
              }
          let productUpdateInfo = {
            title: this.productData.title,
            price:this.productData.price,
            old_price: this.productData.old_price,
            description: this.productData.description,
            category_id: this.productData.category_id,
            unit:this.productData.unit,
          }

          
  
        formData.append('productUpdateInfo', JSON.stringify(productUpdateInfo))
        formData.append("_method", "put");
        const router = useRouter()
        await axios.post(`/product/${this.productData.id}`, formData).then(response => {
                console.log(response.data);
                this.$router.push('/allProduct');
            }).catch(error => {
                this.errors = error.response.data.errors
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
    },
    getProductDataForUpdate(dropzone){
        this.productData = JSON.parse(this.$route.query.product_data);
        console.log(this.productData)
        for (let index = 0; index < this.productData.images.length; index++) {
            let imageUrl = this.productData.images[index].name
                 fetch(imageUrl)
  .then(response => response.blob()) // Use .arrayBuffer() instead of .blob() if you need an array buffer
  .then(blob => {
    // Create a File object
    const fileToAdd = new File([blob], 'filename.jpg', { type: 'image/jpeg' });

    // Add the file to the Dropzone instance
    dropzone.addFile(fileToAdd);
  })
  .catch(error => {
    // Handle any errors that occurred during fetching or file creation
    console.error('Error fetching the image:', error);
  });        
        };
 
    }

    }
  };
  </script>
  <style>
    .dz-progress{
      display: none!important;
    }
  </style>
  
  
  
  
  
  
  
  
  