@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{url('/empleado/'.$empleado->id)}}"  method="post" enctype="multipart/form-data"><!--para la foto-->
        @csrf
        {{method_field('PATCH')}}
        @include('empleado.form',['modo'=>'editar']);
    </form>
</div>
@endsection   

