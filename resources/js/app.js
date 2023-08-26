import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import Test from './pages/Test.vue';
import mitt from 'mitt'
import Cart from './pages/frontend/Cart.vue';
import CartDetails from './pages/frontend/CartDetails.vue';
import routes from './router.js';
import axios from 'axios'


const router = createRouter({
  history: createWebHistory(),
  routes
});

const emitter = mitt()

const app = createApp({});
app.config.globalProperties.$axios = axios;
app.config.globalProperties.emitter = emitter;
app.config.globalProperties.$globalAddToCart = function(id='', qty = 1) {
  let cartQty = localStorage.getItem('cartQty')
  if (id!==null && qty == 1) {
    let cartItemData = localStorage.getItem(id)
      cartQty = localStorage.getItem('cartQty')
      if(cartItemData == null){
              let choicedProductData = this.products.data.find(product=>{
                  return product.id === id
              })
              localStorage.setItem(id, JSON.stringify([choicedProductData.title, choicedProductData.images[0].name, choicedProductData.price, qty, id]))
      } else{
          let addToCartData = JSON.parse(cartItemData)
          localStorage.setItem(id, JSON.stringify([addToCartData[0], addToCartData[1], addToCartData[2],  qty+addToCartData[3], id]))
      }

      if(cartQty!==null){
            let qty = localStorage.getItem('cartQty')
            cartQty = parseInt(qty)
            localStorage.setItem('cartQty', ++cartQty)
        } else{
            localStorage.setItem('cartQty', 1)
            cartQty = 1
      }
   } else if(id!==null && qty > 1 ){
     let choicePro = JSON.parse(localStorage.getItem(id))
     let actualQty = parseInt(cartQty) - parseInt(choicePro[3]) + qty
     localStorage.setItem(id, JSON.stringify([choicePro[0], choicePro[1], choicePro[2], qty, id]))
     localStorage.setItem('cartQty', actualQty )
   } 
   this.emitter.emit('my-event', cartQty)
};
app.component('Test', Test);
app.component('Cart', Cart);
app.component('CartDetails', CartDetails);

app.use(router);
app.mount('#mains');
