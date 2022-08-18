<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/form', function () {
    return view('form');
});

Route::post('/procesa', function () {
    $marcas  = [ 'samsung', 'audiotecnica', 'boss', 'senheisser', 'apple', 'asus' ];
    $nombre = request(key: 'nombre');
    return view('procesa',['nombre'=> $nombre, 'marcas'=>$marcas]);
});

Route::get('/listaRegiones', function (){
    $regiones = DB::select('SELECT idRegion, regNombre FROM regiones');
    return view('listaRegiones',['regiones'=>$regiones]);
});

Route::get('/inicio',function (){
    return view('inicio');
});

//------------- ROUTE DE REGIONES------------//
Route::get('/regiones', function () {
    $regiones = DB::select('SELECT idRegion, regNombre FROM regiones');
    return view('regiones',['regiones'=>$regiones]);
});

Route::get('/region/create', function () {
    return view('regionCreate');
});

Route::post('/region/store', function () {
    $regNombre = request(key:'regNombre');
    try{
        DB::insert('insert into regiones (regNombre) values (:regNombre)',[$regNombre]);
        return redirect('/regiones')->with(['mensaje'=>"Region: $regNombre agregada correctamente",'css'=>'success']);
    }
    catch(throwable $th){
        return redirect('/regiones')->with(['mensaje'=>"No se pudo agregar la region: $regNombre",'css'=>'danger']);
    }
});

Route::get('/region/edit/{id}', function ($id) {
   //$region = DB::select('SELECT idRegion, regNombre FROM regiones WHERE idRegion = :id',[$id]);
    $region = DB::table('regiones')->where('idRegion', $id)->first();
    return view('regionEdit',['region'=>$region]);
});

Route::post('/region/update', function () {
    $regNombre = request(key: 'regNombre');
    $idRegion = request(key: 'idRegion');
    try{
        DB::update('UPDATE regiones SET regNombre = :regNombre WHERE idRegion = :idRegion', [$regNombre,$idRegion]);
        return redirect('/regiones')->with(['mensaje'=>"Region actualizada",'css'=>'success']);
    }
    catch(throwable $th){
        return redirect('/regiones')->with(['mensaje'=>"No se ha podido modificar la region",'css'=>'danger']);
    }
});

Route::get('/region/delete/{id}', function ($id) {
    $cantidad = DB::table('destinos')->where('idRegion', $id)->count();
    $region = DB::table('regiones')->where('idRegion',$id)->first();
    return view('regionDelete',['cantidad'=>$cantidad,'region'=>$region]); 
 });

 Route::post('/region/destroy', function () {
    try{
        $idRegion = request(key:'idRegion');
        DB::table('regiones')->where('idRegion',$idRegion)->delete();
        return redirect('/regiones')->with(['mensaje'=>"Region borrada",'css'=>'success']);
    }
    catch(throwable $th){
        return redirect('/regiones')->with(['mensaje'=>"No se ha podido eliminar la region",'css'=>'danger']);
    }
 
 });

 //------------- ROUTE DE DESTINOS------------//
Route::get('/destinos', function(){
    $destinos = DB::select('SELECT * FROM destinos as d INNER JOIN regiones as r ON r.idRegion = d.idRegion'); //INNER JOIN por tener foreign key
    return view('destinos',['destinos'=>$destinos]);
});

Route::get('/destino/create', function () {
    $regiones = DB::select('SELECT idRegion, regNombre FROM regiones');
    return view('destinoCreate',['regiones'=>$regiones]);
});

Route::post('/destino/store', function () {
    try{
        $destNombre = request(key:'destNombre');
        $idRegion = request(key:'idRegion');
        $destPrecio = request(key:'destPrecio');
        $destAsientos = request(key:'destAsientos');
        $destDisponibles = request(key:'destDisponibles');
        DB::insert('INSERT INTO destinos (destNombre,idRegion,destPrecio,destAsientos,destDisponibles) values (:destNombre,:idRegion,:destPrecio,:destAsientos,:destDisponibles)',[$destNombre,$idRegion,$destPrecio,$destAsientos,$destDisponibles]);
        return redirect('/destinos')->with(['mensaje'=>"Destino Agregado correctamente",'css'=>'success']);
    }
    catch(throwable $th){
        return redirect('/destinos')->with(['mensaje'=>"No se ha podido agregar el destino",'css'=>'danger']);
    }
 });

Route::get('/destino/edit/{id}',function($id){
     $destino = DB::table('destinos')->where('idDestino', $id)->first();
     $regiones = DB::select('SELECT * from regiones');
     return view('destinoEdit',['destino'=>$destino,'regiones'=>$regiones]);
});

Route::post('/destino/update', function () {
    $idDestino = request(key:'idDestino');
    $destNombre = request(key:'destNombre');
    $destPrecio = request(key:'destPrecio');
    $destAsientos = request(key:'destAsientos');
    $destDisponibles = request(key:'destDisponibles');

    try{
        DB::update('UPDATE destinos SET destNombre = :destNombre, destPrecio = :destPRecio, destAsientos = :destAsientos, destDisponibles = :destDisponibles WHERE idDestino = :idDestino', [$destNombre,$destPrecio,$destAsientos,$destDisponibles,$idDestino]);
        return redirect('/destinos')->with(['mensaje'=>"Destino actualizado",'css'=>'success']);
    }
    catch(throwable $th){
        return redirect('/destinos')->with(['mensaje'=>"No se ha podido actualizar el destino",'css'=>'danger']);
    }
});


 Route::get('/destino/delete/{id}', function ($id) {
    $destino = DB::select('SELECT * from destinos AS d INNER JOIN regiones as r ON r.idRegion = d.idRegion WHERE idDestino = :id', [$id]);
    return view('destinoDelete',['destino'=>$destino[0]]);
 });

 ROute::post('/destino/destroy', function(){
    $id = request(key:'idDestino');
    try{
        DB::delete('DELETE destinos WHERE idDestino = :id', [$id]);
        return redirect('/destinos')->with(['mensaje'=>"Destino borrada",'css'=>'success']);
    }catch(throwable $th){
        return redirect('/destinos')->with(['mensaje'=>"No se ha podido eliminar el destino",'css'=>'danger']);
    }
 });