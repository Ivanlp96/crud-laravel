@extends('layouts.app')

@section('content')
<div class="container">

    @if(Session::has('mensaje')) 
    <div class="alert alert-info alert-dismissible" role="alert" > 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"></span>
        </button>
    </div>
        {{Session::get('mensaje')}}
    @endif
   
    
<!--si hay un mensaje muestra el mensaje en la parte de abajo-->

<a href="{{url('empleado/create')}}" class="btn btn-success">Registrar nuevo empleado</a>
<br><br>

<table class="table table-dark">
    <thead class="thead-dark"> <!--Cabecera-->
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody> <!--cuerpo-->
        @foreach($empleado as $empleados)  
        <tr>
            <td>{{$empleados->id}}</td>
            <td> <img class="img-thumbnail img-fluid" src="{{asset('storage').'/'.$empleados->Foto}}" width="100"  alt=""> <!--para acceder y mostrar la foto--></td>
            <td>{{$empleados->Nombre}}</td>
            <td>{{$empleados->Apellido}}</td>    
            <td>{{$empleados->Correo}}</td>
            <td> 
                <a href="{{url('/empleado/'.$empleados->id.'/edit')}}" class="btn btn-warning"> <!--envia la informacion de empleado
            pero se utiliza la intruccion de edit y muestre el formulario-->
                editar
                </a>
                    
                <form action="{{url('/empleado/'.$empleados->id)}}" method="post" class="d-inline"> <!--enviar a traves del formulario el id a eliminar-->
                @csrf <!--laravel necesita siempre esta llave porque cualquier formulario podria enviar info y borrarlo-->
                {{method_field('DELETE')}} <!--convierte el metodo post en delete que es necesario para borrar-->
                <input class="btn btn-danger" type="submit" onclick="return confirm('¿Quieres borrar?')" value="Borrar">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    {{ $empleado->links() }}
</div>
@endsection 