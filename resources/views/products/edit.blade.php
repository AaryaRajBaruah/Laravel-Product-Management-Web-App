
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ProManage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>

    <div class="bg-dark text-center text-white py-3">
            <h1 class="h2">ProManage</h1>
    </div>

    <div class="container mb-5">
        <div class="row">
            <div class="d-flex justify-content-end p-0 mt-3 ">
                <a href="{{route('products.index')}}" class="btn btn-dark">Back</a>
            </div>
            <div class="card p-0 mt-3">
                <div class="card-header bg-dark text-white">
                    <h4 class="h4">Edit Product</h4>
                </div>
                <div class="card-body shadow-lg">
                    <form action="{{route('products.update',$product->id)}}" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"  value="{{old('name',$product->name)}}" id="name" class="form-control @error('name')is-invalid @enderror" name="name" placeholder="Enter Name">
                            @error('name')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" id="image" class="form-control @error('image')is-invalid @enderror" name="image">
                            @error('image')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                            @if(!empty($product->image)) 
                                        <img class="rounded mt-3" src="{{asset('uploads/products/'.$product->image)}}" width="150">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" value="{{old('sku',$product->sku)}}" id="sku" class="form-control @error('sku')is-invalid @enderror" name="sku" placeholder="SKU">
                            @error('sku')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" value="{{old('price',$product->price)}}" id="price" class="form-control @error('price')is-invalid @enderror" name="price" placeholder="Enter Price">
                            @error('price')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="Active" {{$product->status == 'Active' ? 'selected' : ''}} >Active</option>
                                <option value="Inactive" {{$product->status == 'Inactive' ? 'selected' : ''}}>Inactive</option>
                            </select>
                        </div>
                        <button class="btn btn-dark">Update</button>
                    </form>
                    


                </div>           
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>

