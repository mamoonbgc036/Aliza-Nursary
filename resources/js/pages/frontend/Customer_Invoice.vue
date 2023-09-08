<template>
    <div id="hello">
      <div class="test">
        <button @click="generatePdf" class="float-right"><i class="fa fa-print"></i></button>
        <h1 class="text-center">Invoice</h1>
        <div class="d-flex justify-content-center">
          <img src="upload/product//tress.jpg" alt="Product">
          <div>
            <h3>ALEZA</h3>
            <p>Phone : <span>01814418723</span></p>
            <p>505 Silk Rd, New York</p>
          </div>
        </div>
        <div id="customer_address">
          <h3>{{ address.name }}</h3>
          <p>Cell: {{ address.phone }}</p>
          <p>{{ address.house }}</p>
          <p>{{ address.street }}</p>
          <p>{{ address.city }}</p>
        </div>
        <div>
          <p>Order Date: 15 December'2023</p>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Sl</th>
                <th>Name</th>
                <th>Unit Price</th>
                <th>Qty</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(cartItem, index=1) in cartItems" :key="index">
                <td>{{ index }}</td>
                <td>{{ cartItem[0] }}</td>
                <td>${{ cartItem[2] }}</td>
                <td>{{ cartItem[3] }}</td>
                <td>${{ parseInt(cartItem[2] * cartItem[3]) }}</td>
              </tr>
              <!-- Add more rows for additional products -->
            </tbody>
            <tfoot>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Total:</td>
                <td>${{ cartTotal }}</td> <!-- Add the total subtotal value here -->
              </tr>
            </tfoot>
          </table>
          <p>In hand date : 20 December'2023 </p>
        </div>
      </div>

      <!-- <h1>Hello</h1>
      <img src="upload/product//tress.jpg" alt="Product">
      <button @click="generatePdf">Generate PDF</button> -->
    </div>
  </template>
  
  <script>
  import html2pdf from 'html2pdf.js';
  
  export default {
    data(){
      return{
        cartItems:[],
        cartTotal:0,
        address:{
          name:'',
          phone:'',
          house:'',
          street:'',
          city:'',
        }
      }
    },  
    mounted(){
      this.getCartItems()
    },
    methods: {
      async generatePdf() {
        const content = document.getElementById('hello'); // Get the content to convert to PDF
  
        // Configure the PDF options
        const pdfOptions = {
          margin: [10, 0],
          filename: 'test',
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: { scale: 2 },
          jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        };
  
        const pdfBlob = await html2pdf().from(content).set(pdfOptions).output('blob');

        // Create a data URL from the PDF blob
        const pdfDataUri = URL.createObjectURL(pdfBlob);

        // Open the PDF in a new tab
        window.open(pdfDataUri, '_blank');
      },
      
      getCartItems()
            {
                let itemKeys = Object.keys(localStorage)
                this.cartTotal = 0
                itemKeys.forEach(keys=>{
                    let itemValue = JSON.parse(localStorage.getItem(keys))
                    if(!Number.isInteger(itemValue) && typeof(itemValue)!=='string'){
                        this.cartItems.push(itemValue) 
                        this.cartTotal += parseInt(itemValue[2])*itemValue[3]
                    }               
                })
                console.log(this.cartItems)
                let customer_address = JSON.parse(localStorage.getItem('address'))
                let address = customer_address.split(',')
                this.address.name = address[0]
                this.address.phone = address[1]
                this.address.house = address[2]
                this.address.street = address[3]+','+address[4]
                this.address.city = address[5]
            },
    },
  };
  </script>
  <style>
  #hello img{
    width: 61px;
    height: 104px;
  }
  p{
    margin: 0!important;
  }
  .w-75{
    margin: 0 auto;
  }
  #hello .test{
    width: 75%;
    margin: 0 auto;
  }
</style>
  