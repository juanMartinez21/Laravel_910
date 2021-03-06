<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()//Listar Categorias
    {
        $categorias = Categoria::all();//Select * from Categorias
        //$categorias = Categoria::orderBy('id','desc')->get();
        return $categorias;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoria = new Categoria;
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        $categoria->update();//actualizar
    }

    public function desactivar(Request $request){
        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion = '0';
        $categoria->update();//actualizar
    }

    public function activar(Request $request){
        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion = '1';
        $categoria->update();//actualizar
    }
}
