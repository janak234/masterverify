@foreach ($products as $Product)
<div class="col-md-3 col-lg-3 mb-3" >
    <div class="card h-100" >
      <img class="card-img-top" src="/{{$Product->image}}" alt="{{$Product->name}}" style="height: 200px;object-fit: cover;" onclick="select({{$Product->id}})">
      <div class="card-body" style="background: #f2f2f2;">
        <h5 class="card-title">{{$Product->name}}</h5>
        <input required type="radio" name="products" class="form-control c" id="p{{$Product->id}}" value="{{$Product->id}}" style="margin-bottom: 5px">
        <label for="">No of Codes</label>
        <input  type="text" name="qty[]" class="form-control qt" value="1" required min="1">
      </div>
    </div>
</div>
@endforeach
