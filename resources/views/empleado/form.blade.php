    <h1>{{$modo}} Empleado</h1>

    @if(count($errors)>0) <!--si existe error entonces-->
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error) <!--Muestra los errores uno en uno-->
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group">
        <label for="Nombre">Nombre</label>
        <input type="text" class="form-control" name="Nombre" value="{{isset($empleado->Nombre)?$empleado->Nombre:old('Nombre')}}" id="Nombre"> <!--valido los datos a mostrar con isset-->
    </div>
    <div class="form-group">
        <label for="Apellido">Apellido</label>
        <input type="text" class="form-control" name="Apellido" value="{{isset($empleado->Apellido)?$empleado->Apellido:old('Apellido')}}"  id="Apellido">
    </div>
    <div class="form-group">
        <label for="Correo">Correo</label>
        <input type="text" class="form-control" name="Correo" value="{{isset($empleado->Correo)?$empleado->Correo:old('Correo')}}"  id="Correo">
    </div>
    <div class="form-group">
    <label for="Foro"></label>  
    @if(isset($empleado->Foto))
    <img class="img-thumbnail img-fluid" src="{{asset('storage').'/'.$empleado->Foto}}" width="100" alt="">
    @endif
    <input  class="form-control" type="file"  name="Foto"  value=""  id="Foto">
    </div>
    <br>
    <input class="btn btn-success" type="submit" value="{{$modo}} datos">
    <a class="btn btn-primary" href="{{url('empleado/')}}">Regresar</a> 
    <br>


