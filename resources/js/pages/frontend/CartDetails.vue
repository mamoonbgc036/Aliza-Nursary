<template>
        <div class="cart-area section-padding-0-100 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cart-table clearfix">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Products</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>TOTAL</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cartItem in cartItems">
                                    <td class="cart_product_img">
                                        <a href="#"><img :src="cartItem[1]" alt="Product"></a>
                                        <h5>{{ cartItem[0] }}</h5>
                                    </td>
                                    <td class="qty">
                                        <div class="quantity">
                                            <input type="number" v-on:change="getCartValue(cartItem[4], cartItem[3])" class="qty-text" id="qty" step="1" min="1" max="99" name="quantity" v-model="cartItem[3]">
                                        </div>
                                    </td>
                                    <td class="price"><span>${{ cartItem[2] }}</span></td>
                                    <td class="total_price"><span>${{ parseInt(cartItem[2] * cartItem[3]) }}</span></td>
                                    <td class="action"><a href="#" @click.prevent="removePro(cartItem[4], cartItem[3])" ><i class="icon_close"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row justify-content-end">

                <!-- Coupon Discount(latter implement) -->
                <!-- <div class="col-12 col-lg-6">
                    <div class="coupon-discount mt-70">
                        <h5>COUPON DISCOUNT</h5>
                        <p>Coupons can be applied in the cart prior to checkout. Add an eligible item from the booth of the seller that created the coupon code to your cart. Click the green "Apply code" button to add the coupon to your order. The order total will update to indicate the savings specific to the coupon code entered.</p>
                        <form action="#" method="post">
                            <input type="text" name="coupon-code" placeholder="Enter your coupon code">
                            <button type="submit">APPLY COUPON</button>
                        </form>
                    </div>
                </div> -->

                <!-- Cart Totals -->
                <div class="col-12 col-lg-6">
                    <div class="cart-totals-area mt-70">
                        <div class="subtotal d-flex justify-content-between">
                            <h5>CART TOTAL</h5>
                            <h5>${{ cartTotal }}</h5>
                        </div>
                        <!-- <div class="shipping d-flex justify-content-between">
                            <h5>Shipping</h5>
                            <div class="shipping-address">
                                <form action="#" method="post">
                                    <select class="custom-select">
                                      <option selected>Country</option>
                                      <option value="1">USA</option>
                                      <option value="2">Latvia</option>
                                      <option value="3">Japan</option>
                                      <option value="4">Bangladesh</option>
                                    </select>
                                    <input type="text" name="shipping-text" id="shipping-text" placeholder="State">
                                    <input type="text" name="shipping-zip" id="shipping-zip" placeholder="ZIP">
                                    <button type="submit">Update Total</button>
                                </form>
                            </div>
                        </div>
                        <div class="total d-flex justify-content-between">
                            <h5>Total</h5>
                            <h5>$9.99</h5>
                        </div> -->
                        <div class="checkout-btn">
                            <router-link :to="{ name: 'checkout', params: { total_charge: cartTotal } }" class="btn alazea-btn w-100">PROCEED TO CHECKOUT</router-link>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                cartItems:[],
                cartTotal:0
            }
        },
        mounted(){
            this.getCartItems()
        },
        methods:{
            getCartItems()
            {
                let itemKeys = Object.keys(localStorage)
                this.cartTotal = 0
                itemKeys.forEach(keys=>{
                    let itemValue = JSON.parse(localStorage.getItem(keys))
                    if(!Number.isInteger(itemValue)){
                        this.cartItems.push(itemValue) 
                        this.cartTotal += parseInt(itemValue[2])*itemValue[3]
                    }               
                })
            },
            getCartValue(id, qty){
                this.$globalAddToCart(id,qty)
                this.cartItems = []
                this.getCartItems()
            },
            removePro(id,qty){
                localStorage.removeItem(id)
                this.cartItems = []
                let sum = parseInt(localStorage.getItem('cartQty'))-qty
                localStorage.setItem('cartQty', sum)
                this.$globalAddToCart(null,null)
                this.getCartItems()
            }
        }
    }
</script>