<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h4 class="text-center text-success">Stripe Checkout</h4>
        <form @submit.prevent="handlePayment" class="bg-white p-4 rounded shadow">
          <div class="mb-3">
            <label for="card-number" class="form-label">Card Number</label>
            <div id="card-number" ref="cardNumber" class="form-control"></div>
          </div>

          <div class="mb-3">
            <label for="card-expiry" class="form-label">Expiration Date</label>
            <div id="card-expiry" ref="cardExpiry" class="form-control"></div>
          </div>

          <div class="mb-3">
            <label for="card-cvc" class="form-label">CVC</label>
            <div id="card-cvc" ref="cardCvc" class="form-control"></div>
          </div>

          <button
            type="submit"
            class="btn btn-success w-100"
          >
          <div :class="{'lds-dual-ring': btn_state==false }"></div>
            <span v-show="btn_state">Pay ${{ total_charge }}</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>


<script>
import axios from 'axios';
import { loadStripe } from '@stripe/stripe-js';
import { useRouter } from 'vue-router';

export default {
  props:['total_charge'],
  data() {
    return {
      stripe: null,
      elements: null,
      cardNumber: null,
      cardExpiry: null,
      cardCvc: null,
      btn_state: true,
    };
  },
  mounted() {
    this.initializeStripe();
  },
  methods: {
    async initializeStripe() {
      const stripe = await loadStripe('pk_test_51KcneuHC9p5F3lsEcbrAnnJcx3KLrzZNXESWwIizvV2VzSkkHYRGEXsl3p0Cg8RCgkc9laFJiUMmQFGohft3BM2700lnAMaRIm');
      const elements = stripe.elements();

      this.stripe = stripe;
      this.elements = elements;

      this.cardNumber = elements.create('cardNumber');
      this.cardExpiry = elements.create('cardExpiry');
      this.cardCvc = elements.create('cardCvc');

      this.cardNumber.mount(this.$refs.cardNumber);
      this.cardExpiry.mount(this.$refs.cardExpiry);
      this.cardCvc.mount(this.$refs.cardCvc);
    },
    async handlePayment() {
      this.btn_state = false
      const { token, error } = await this.stripe.createToken(this.cardNumber);
      if (error) {
        console.error(error.message);
        this.btn_state=true
      } else {
        this.processPayment(token.id, this.total_charge);
      }
    },
    processPayment(token, amount) {
      axios.post('/order', { token, amount })
        .then(response => {
          localStorage.setItem('order_id', JSON.stringify(response.data.id))
          const router = useRouter();
          this.$router.push('/address');
        })
        .catch(error => {
          console.log(error.message)
        });
    },
  },
};
</script>
<style>
.lds-dual-ring {
  display: inline-block;
  width: 35px;
  height: 35px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 30px;
  height: 30px;
  margin: 4px;
  border-radius: 50%;
  border: 4px solid #fff;
  border-color: #fff transparent #fff transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
