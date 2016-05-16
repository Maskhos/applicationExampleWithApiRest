@extends('layouts.app')

@section('content')
<form enctype="multipart/form-data" action="{{ url('prueba/subir') }}" method="POST">
  {!! csrf_field() !!}
  <input type="text" name="name" />
  <input type="file" name="image"  />
  <input type="submit" name="submit" value="submit" />
</form>
<div class="row">
  <div class="col-xs-6">
    @foreach($prueba as $pruebas)
    <table class="table table-bordered">
      <thead><tr><td>name</td><td>image</td></tr></thead>
      <tbody><tr><td>{{$pruebas->name}}</td><td><img src="{{$pruebas->image}}" /></td></tr></tbody>

    </table>

    @endforeach
  </div>
</div>
@endsection
