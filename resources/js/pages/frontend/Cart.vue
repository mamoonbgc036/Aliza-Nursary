<template>
    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Cart <span class="cart-quantity">({{ cartQty }})</span></span>
</template>
<script>
    export default{
      data(){
        return{
          cartQty: 0
        }
      },
        created(){
    this.emitter.on('my-event', (evt) => {
      this.cartQty = evt
    })
  }
    }
</script>