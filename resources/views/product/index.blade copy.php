@extends('adminLayout')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row pt-2 pb-2">
            @include('includes.bredcum',['title'=>'Product Index'])
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">All Product</h5>
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('product.create')}}"
                                class="btn btn-success btn-sm waves-effect waves-light">
                                Add Product
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Vendor</th>
                                        <th scope="col">Sale Price</th>
                                        <th scope="col">Old Price</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                    <tr class="product_display_row">
                                        <th scope="row">1</th>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>
                                            <div class="row">
                                                @forelse($product->images as $image)
                                                <div class="col-md-6" id="product_image">
                                                    <img src="/{{ $image->name }}" class="rounded" alt="">
                                                </div>
                                                @empty
                                                <h1>No Images</h1>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td>{{ Auth::user()->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->old_price }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye"></i>
                                                View
                                            </a>
                                            <a href="{{ route( 'product.edit', $product->id ) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye"></i>
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">No Product Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--start overlay-->
        <div class="overlay"></div>
        <!--end overlay-->

    </div>
    <!-- End container-fluid-->

</div>
@endsection