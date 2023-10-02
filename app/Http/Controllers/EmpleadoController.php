<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // para paginar //clase que contiene elemento que nos permite borrar archivos del storage

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['empleado']=Empleado::paginate(1); // consultamos la informacion de la base de datos a partir de modelo y mostramos 5 
        return view('empleado.index',$datos); //le pasamos al index la variable datos 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $campos=[
            'Nombre'=> 'required|max:100', //nombre requerido de tipo string maximo 100 lineas
            'Apellido' => 'required|max:100',
            'Correo' => 'required|email',   
            'Foto' => 'required|max:10000|Mimes:jpeg,pnj,jpg', //tipo de foto y tamaño 
        ];
        $mensajes=[
            'required'=>'El :attribute es requerido', // atribute es un comodin se va remplazar con lo que falte
            'Foto.required'=>'La foto es requerida',
        ];

        $this->validate($request,$campos,$mensajes); //todo lo que se envia se valida y muestra los mensajes

        //$datosEmpleado = request()->all();
        $datosEmpleado = request()->except('_token');// recolecta todos los datos menos el token
        if($request->hasfile('Foto')){ //si existe un archivo
            $datosEmpleado['Foto']=$request->file('Foto')->store('upload','public'); //alteramos el nombre y los insertamos en public
        }
        Empleado::insert($datosEmpleado); //toma el modelo y inserta los datos en la base de datos
        return redirect('empleado')->with('mensaje','Empleado Agregado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleado=Empleado::findOrfail($id); //buscamos el id y si la encuentra se la asigna a la variable 
        return view('empleado.edit',compact('empleado')); //usamos compact para pasar los datos y lo retornamos a la vista
    }    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $campos=[
            'Nombre'=> 'required|max:100', //nombre requerido de tipo string maximo 100 lineas
            'Apellido' => 'required|max:100',
            'Correo' => 'required|email',   
        ];
        $mensajes=[
            'required'=>'El :attribute es requerido', // atribute es un comodin se va remplazar con lo que falte
        ];
        if($request->hasfile('Foto')){ //pregunto si tiene foto o no
            $campos=[ 
                'Foto' => 'required|max:10000|Mimes:jpeg,pnj,jpg', //tipo de foto y tamaño 
            ];
            $mensajes=[
                'Foto.required'=>'La foto es requerida',
            ];
        }


        $this->validate($request,$campos,$mensajes); //todo lo que se envia se valida y muestra los mensajes

        $datosEmpleado = request()->except(['_token','_method']);// recolecta todos los datos menos el token

        if($request->hasfile('Foto')){ //si existe un archivo
            $empleado=Empleado::findOrfail($id);
            Storage::delete(['public/'.$empleado->Foto]); //elimina la foto guardada en la ruta 
            $datosEmpleado['Foto']=$request->file('Foto')->store('upload','public'); //alteramos el nombre y los insertamos en public
        }
        
        Empleado::where('id','=',$id)->update($datosEmpleado);//comparo los id de empleado con el que le envio, si encuentra lo actualiza
        
        $empleado=Empleado::findOrfail($id); //buscamos el id y si la encuentra se la asigna a la variable 
        //return view('empleado.edit',compact('empleado')); //usamos compact para pasar los datos y lo retornamos a la vista
        return redirect('empleado')->with('mensaje','Empleado modificado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empleado=Empleado::findOrfail($id);
        if(Storage::delete('public/'.$empleado->Foto)){
            Empleado::destroy($id); // recibe el id y lo elimina
        }
        return redirect('empleado')->with('mensaje','Empleado Borrado');
    }
    
}
