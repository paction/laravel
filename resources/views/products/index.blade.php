@extends('layouts.app')

@section('content')

  <!-- Bootstrap template -->
  <div class="container">
  @if (count($products) > 0)
    <div class="row">
      <div class="col-sm-4">
        <div class="panel panel-primary">
          <div class="panel-heading">A</div>
          <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
          <div class="panel-footer">D1</div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="panel panel-danger">
          <div class="panel-heading">B</div>
          <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
          <div class="panel-footer">D2</div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="panel panel-success">
          <div class="panel-heading">C</div>
          <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
          <div class="panel-footer">D3</div>
        </div>
      </div>
    </div>
    @else
    <div class="panel panel-danger">
      There are no products available in the store
    </div>
    @endif
  </div>

@endsection
