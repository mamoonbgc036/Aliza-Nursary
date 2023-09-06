import ProductView from './pages/frontend/ProductView.vue';
import CartDetails from './pages/frontend/CartDetails.vue';
import GetAddress from './pages/frontend/GetAddress.vue';
import Checkout from './pages/frontend/Checkout.vue';
import ProductEdit from './pages/ProductEdit.vue';
import ProductIndex from './pages/ProductIndex.vue';
import ProductCreate from './pages/ProductCreate.vue';
import Dashboard from './pages/users/Dashboard.vue';

const routes = [
  {
    path: '/',
    component: ProductView,
    name: 'ProductView'
  },
  {
    path: '/checkout/:total_charge',
    name: 'checkout',
    component: Checkout,
    props: true,
  },
  {
    path: '/address',
    component: GetAddress,
    name: 'GetAddress'
  },
  {
    path: '/order',
    component: CartDetails,
    name: 'CartDetails'
  },
  {
    path: '/edit',
    component: ProductEdit,
    name: 'ProductEdit'
  },
  {
    path: '/product/create',
    component: ProductCreate,
    name: 'create'
  },
  {
    path: '/product',
    component: ProductIndex,
    name: 'product'
  },
  {
    path: '/dashboard',
    component: Dashboard,
    name: 'dashboard',
  },
];

export default routes;
