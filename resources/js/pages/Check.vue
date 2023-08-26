<script>
  function test(id,qty){
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
       let actualQty = cartQty - parseInt(choicePro) + qty
       localStorage.setItem(id, JSON.stringify([choicePro.title, choicePro.images[0].name, choicePro.price, qty, id]))
       localStorage.setItem('cartQty', actualQty )
     } 
     this.emitter.emit('my-event', cartQty)
  }
</script>