@extends('adminLayout')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row pt-2 pb-2">
            @include('includes.bredcum',['title'=>'Edit Product'])
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Product Edit</div>
                        <hr>
                        <form method="POST" action="{{ route( 'product.update', $productEdit->id ) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="input-21" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $productEdit->title }}" name="title"
                                        class="form-control" id="input-21" placeholder="Enter Your Name">
                                    @error('title')
                                    <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="basic-textarea" class="col-sm-2 col-form-label">Product Description</label>
                                <div class="col-sm-10">
                                    <textarea rows="4" name="description" class="form-control"
                                        id="basic-textarea">{{ $productEdit->description }}</textarea>
                                </div>
                                @error('description')
                                <span class="text-warning">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label for="input-23" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $productEdit->price }}" class="form-control is-invalid"
                                        id="validationServer03" name="price" placeholder="Enter Current Price">
                                    @error('price')
                                    <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-23" class="col-sm-2 col-form-label">Old Price</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $productEdit->old_price }}"
                                        class="form-control is-invalid" id="validationServer03" name="old_price"
                                        placeholder="Enter Old Price">
                                    @error('old_price')
                                    <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-23" class="col-sm-2 col-form-label">Category</label>
                                <div class="col-sm-10">
                                    <select name="category_id" id="" class="form-control">
                                        @if($categories)
                                        @foreach($categories as $category)
                                        <option {{ $productEdit->category_id ===  $category->id ? 'selected' : '' }}
                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('category_id')
                                    <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-23" class="col-sm-2 col-form-label">Unit</label>
                                <div class="col-sm-10">
                                    <select name="unit" id="" class="form-control">
                                        @if(empty($units))
                                        @foreach($units as $unit)
                                        <option value="{{ $unit->name }}">{{ $unit->name }}</option>
                                        @endforeach
                                        @else
                                        <option value="pc">pc</option>
                                        @endif
                                    </select>
                                    @error('unit')
                                    <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-25" class="col-sm-2 col-form-label">Upload Image</label>
                                <div class="col-sm-10">
                                    <?php 
                                        if(!empty($productEdit->images)){
                                            if(is_array($productEdit->images)){
                                                foreach ($productEdit as $image) {
                                                    ?>
                                    <img src="/{{ $image->name }}" class="rounded" height="55px" alt="">
                                    <?php
                                                }
                                            }else{
                                                ?>
                                    <img src="/{{ $productEdit->images[0]->name }}" class="rounded w-25" alt="">
                                    <?php
                                            }
                                        }
                                    ?>
                                    <input type="file" class="form-control image-upload" id="input-25" name="images[]"
                                        multiple>
                                    <div id="image-preview"></div>
                                    @error('images')
                                    <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!--End Row-->
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-white px-5"><i class="icon-lock"></i>
                                        Create</button>
                                </div>
                            </div>
                        </form>
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