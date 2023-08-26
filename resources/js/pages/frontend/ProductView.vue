<template>
   <div class="col-12 col-sm-6 col-lg-3" v-for="product in products.data">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Product Image -->
                        <div class="product-img">
                            <a class="product_img_height" href="shop-details.html"><img :src="product.images[0] ?.name ?? 'upload/product//lE12ITymUxwaIegb3tISmh26pO0TzRb3qxNnKQV9.jpg' "
                                    alt=""></a>
                            <!-- Product Tag -->
                            <div class="product-tag">
                                <a href="#">Hot</a>
                            </div>
                            <div class="product-meta d-flex">
                                <a href="#" class="wishlist-btn"><i class="icon_heart_alt"></i></a>
                                <a href="cart.html" @click.prevent="addToCart(product.id,1)" class="add-to-cart-btn">Add to cart</a>
                                <a href="#" class="compare-btn"><i class="arrow_left-right_alt"></i></a>
                            </div>
                        </div>
                        <!-- Product Info -->
                        <div class="product-info mt-15 text-center">
                            <a href="shop-details.html">
                                <p>{{ product.title }}</p>
                            </a>
                            <h6>${{ product.price }}</h6>
                        </div>
                    </div>
    </div>
    <div class="col-12 text-center" v-show="nextPage <= products.last_page">
        <a href="#" class="btn alazea-btn" @click.prevent="loadMoreProducts">
            <div class="center-wrapper">
                <span :class="active ? 'loader' : ''">{{ active ? '' : 'More' }}</span>
            </div>
        </a>
    </div>
</template>
<script>
import axios from 'axios';
    export default{
        data(){
            return{
                products: [],
                active: false,
                nextPage: 2,
                cartItem : 4
            }
        },
        mounted(){
            this.getProduct()
            this.$globalAddToCart(null, null)
        },
        methods:{
            getProduct(){
                axios.get('/product')
                .then((response)=>{
                this.products = response.data;
                })
                .catch(errors=>{
                console.log(errors)
                })
            },
            loadMoreProducts() {
                this.active = true; // Show loader or loading indicator if you have one

                axios
                    .get(`/product?page=${this.nextPage}`) // Fetch more products using the new endpoint
                    .then((response) => {
                    this.products.data = [...this.products.data, ...response.data.data]; // Append the new products to the existing array
                    console.log(this.products.last_page)
                    this.nextPage = response.data.current_page + 1; // Update the next page number
                    this.active = false; // Hide loader after loading more products
                    })
                    .catch((errors) => {
                    console.log(errors);
                    this.active = false; // Hide loader if there's an error
                    });
            },
            addToCart(id,qty){
                this.$globalAddToCart(id,qty)
            }
        }
    }
</script>
<style>

    .center-wrapper {
        display: flex;
        justify-content: center; /* Horizontal centering */
        align-items: center; /* Vertical centering */
        height: 100%; /* Set the height to 100% to fill the parent container */
    }


/* SPINNER */
    .loader {
    width: 30px;
    height: 30px;
    border: 5px solid #FFF;
    border-bottom-color: #FF3D00;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    } 
</style>