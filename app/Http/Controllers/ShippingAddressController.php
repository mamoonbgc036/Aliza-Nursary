<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;

class ShippingAddressController extends Controller
{
    public function index(){
        dd('ok');
    }
    public function store(Request $request){
        $address = new ShippingAddress();
        $address->name = $request->name;
        $address->order_id = $request->order_id;
        $address->phone = $request->phone;
        $address->address = $request->address;
        return $address->save();
    }
}
