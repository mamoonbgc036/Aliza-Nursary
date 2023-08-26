<template>
  <div class="justify-center w-4/5 mt-4 mx-auto divide-y divide-gray-200">
    <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Sale Price</th>
                                        <th scope="col">Old Price</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product,index) in products.data" :key="product.id" class="product_display_row">
                                        <th scope="row">{{ index+1 }}</th>
                                        <td class="p-5">{{ product.title }}</td>
                                        <td class="p-5">{{ product.category.name }}</td>
                                        <td class="p-5">
                                          <div class="flex flex-row">
                                            <div v-for="image in product.images" class="flex-shrink-0">
                                              <img :src="'/' + image.name" class="w-20 h-20 rounded" alt="">
                                            </div>
                                          </div>
                                        </td>
                                        <td class="p-5">{{ product.price }}</td>
                                        <td class="p-5">{{ product.old_price }}</td>
                                        <td class="p-5">
                                          <button @click="searchProduct(product.id)" class="btn btn-primary"><i class="fa fa-eye mr-2"></i></button>
                                            <router-link :to="{ name: 'ProductEdit', query: { product_data: JSON.stringify(product) } }" class="btn btn-sm btn-primary">
                                              <i class="fas fa-edit mr-2"></i>
                                            </router-link>
                                            <button @click="deleteProduct(product.id)" class="btn btn-primary"><i class="fa fa-trash"></i></button>
                                            <!-- :to="{ name: 'edit-product', params: { product_id: product.id }, query: { product_data: JSON.stringify(product) } }" -->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <TailwindPagination
                        :data="products"
                        @pagination-change-page="getProduct"
                    />
                    <!-- <button @click="prevPage" :disabled="currentPage === 1">Previous</button>
                    
                    
                    
                    <button @click="nextPage" :disabled="currentPage === totalPages">Next</button>  -->
                    <!-- <router-link v-for="(page, index) in products.links" :class="page.active ? 'mark' : ''" :key="index" to="product?page=2">{{ page.label }}</router-link> -->
                    <!-- <router-link v-for="(page, index) in products.links" :class="page.active ? 'mark' : ''" :key="index" :to="`/product?page=${index > 0 ? index : ''}`">{{ page.label }}</router-link> -->
                  </div>
                
  </div>
    <!-- PRODUCT SHOW MODAL -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="fixed inset-0 bg-gray-700 bg-opacity-50"></div>
      <div class="bg-white p-4 rounded-lg z-10 w-1/2">
        <!-- Modal content -->
        <h3 class="text-xl font-semibold mb-4">{{ productShow.title }}</h3>
        <p class="mb-2">{{ productShow.description }}</p>
        <p class="mb-2">Sale Price: {{ productShow.price }}</p>
        <p class="mb-4">Old Price: {{ productShow.old_price }}</p>
        <div class="flex flex-row">
                                            <div v-for="image in productShow.images" class="flex-shrink-0">
                                              <img :src="'/' + image.name" class="w-20 h-20 rounded" alt="">
                                            </div>
                                          </div>

        <!-- Close button -->
        <button @click="showModal = false" class="btn btn-primary">Close</button>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { TailwindPagination } from 'laravel-vue-pagination';
  export default {
    // Vue component logic here
    components:{
      TailwindPagination
    },
    data(){
      return {
        showModal : false,
        products : Object,
        productShow : '',
        totalPages: 0,
        currentPage: 1,
      }
    },

    mounted(){
      this.getProduct()
    },
    methods:{
      getProduct(page=1){
        console.log(page)
        axios.get(`/product?page=${page}`)
        .then((response)=>{
          this.products = response.data;
          console.log(this.products)
          this.totalPages = response.data.last_page;
        })
        .catch(errors=>{
          console.log(errors)
        })
      },
      searchProduct(id){
        this.showModal = true
        this.productShow = this.products.data.find(product=>product.id===id)
      },
      deleteProduct(id){
        axios
        .delete(`/product/${id}`)
        .then(response => {
          // Handle success, e.g., show a success message
          console.log(response.data);
          this.getProduct();
        })
        .catch(error => {
          // Handle error, e.g., show an error message
          console.error(error);
        });
      },
      prevPage() {
      if (this.currentPage > 1) {
        this.getProduct(this.currentPage--);
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.getProduct(this.currentPage++);
      }
    },
    },
    watch: {
      // Watch for changes in the current page and fetch new data
      $route(to, from) {
        const page = parseInt(to.query.page) || 1;
        this.getProduct(page);
      },
    },
  }
  </script>
  
  <style>
  /* CSS styles for the component */

  .mark{
    padding: 8px;
    background-color: blueviolet;
    margin: 3px;
  }
  </style>
  