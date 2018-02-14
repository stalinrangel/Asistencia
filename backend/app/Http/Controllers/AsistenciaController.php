<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Activamos uso de caché.
use Illuminate\Support\Facades\Cache;
use DateTime;
class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asistencia=\App\Asistencia::get();
        $personal=\App\Personal::get();

        for ($i=0; $i < count($asistencia); $i++) { 
            for ($j=0; $j < count($personal); $j++) { 
                if ($asistencia[$i]->legajo==$personal[$j]->LEGAJO) {
                    $asistencia[$i]->persona=$personal[$j];
                }
            }
        }
        $asistencia2=[];
        for ($i=count($asistencia)-1; $i > -1; $i--) { 
            array_push($asistencia2,$asistencia[$i]);
        }
        $asistencia= $asistencia2;
        return response()->json(['asistencia'=>$asistencia], 200);
    }
    public function hora()
    {   
        $hora=new DateTime();
        $hora= $hora->format('Y-m-d H:i:s');
        return json_encode($hora);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   //return $request->input('id');
        $data = explode( ',', $request->input('imagen') );
        $file= base64_decode($data[ 1 ]);
        $folder="/imagenes/";
        $hora=new DateTime();
        $hora= $hora->format('Y-m-d H:i:s');
        //return $request->input('id');
        $nombre=$request->input('id')."-".$this->generarCodigo(6).".png";
        //return 1;
        $destino= public_path().$folder;
        file_put_contents(public_path().$folder.$nombre,$file);

        $asistencia=new \App\Asistencia;
        $asistencia->IDENTIFICA_ID=$request->input('identifica');
        $asistencia->legajo=$request->input('legajo');
        $asistencia->hora=$hora;
        $asistencia->retraso=$request->input('retraso');
        $asistencia->imagen=$request->input('ruta').'imagenes/'.$nombre;
        if ($asistencia->save()) {
             return response()->json(['asistencia'=>$asistencia], 200);
        }else{
             return response()->json(['asistencia'=>$asistencia], 500);
        }
       
        //return asistencia;
        /*Image::make($request->input('imagen'))->save('imagenes');
        return 1;*/
        //return $this->base64_to_jpeg($request->input('imagen'),'prueba.jpg');
    }

    public function base64_to_jpeg($base64_string, $output_file) {

       
        //return $base64_string;
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' ); 

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );

        // clean up the file resource
        fclose( $ifp ); 

        return json_encode($ifp); 

        $id = $ifp;
        $file = $ifp;

        move_uploaded_file($file, '/imagenes/cliente_'.$file);

        if(isset($file))
        {
        echo $file;
        }
        else{ 
        sendResponse(200, 'Error');
        }
        return true;

        
    }

    function generarCodigo($longitud) {

     $key = '';
     $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
     $max = strlen($pattern)-1;
     for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};

     return $key;
    }
 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //cargar una cat
        $categoria = \App\Categoria::with('tipo')->with('rubro')->find($id);

        if(count($categoria)==0){
            return response()->json(['error'=>'No existe la categoría con id '.$id], 404);          
        }else{
            return response()->json(['categoria'=>$categoria], 200);
        } 
    }

    public function categoriaProductos($id)
    {

        //cargar una cat con sus subcat
        $categoria = \App\Categoria::with('tipo')->with('rubro')->with('productos')->find($id);

        if(count($categoria)==0){
            return response()->json(['error'=>'No existe la categoría con id '.$id], 404);          
        }else{

            //cargar las subcat de la cat
            //$categoria = $categoria->with('subcategorias')->get();
            //$categoria->productos = $categoria->productos()->get();
            //$categoria = $categoria->subcategorias;

            return response()->json(['categoria'=>$categoria], 200);
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // Primero comprobaremos si estamos recibiendo todos los campos.

        if ( !$request->input('categorias'))
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['error'=>'Falta el arreglo de categoría(s) a editar.'],422);
        }

        $categorias = json_decode($request->input('categorias'));
        //$categorias = json_decode('[{"categoria_id":192,"rubro_id":3,"tipo_id":3}]')
        //$categorias = json_decode('[{ "name":"John", "age":30, "car":null }]');
        //$categorias = $request->input('categorias');
        //return $categorias;
        for ($i=0; $i < count($categorias) ; $i++) { 

            // Comprobamos si la categoria que nos están pasando existe o no.
            $categoria=\App\Categoria::find($categorias[$i]->categoria_id);

            if (!$categoria)
            {
                // Devolvemos error codigo http 404
                return response()->json(['error'=>'No existe la categoría con id '.$categorias[$i]->categoria_id], 404);
            }      
            //
            // Listado de campos recibidos teóricamente.
            /*if (property_exists($categorias[$i], 'nombre')) {
                $nombre = $categorias[$i]->nombre;
            }else{
                $nombre = null;
            }

            if (property_exists($categorias[$i], 'codigo')) {
                $codigo = $categorias[$i]->codigo;
            }else{
                $codigo = null;
            }*/

            if (property_exists($categorias[$i], 'tipo_id')) {
                $tipo_id = $categorias[$i]->tipo_id;
            }else{
                $tipo_id = null;
            }

            if (property_exists($categorias[$i], 'rubro_id')) {
                $rubro_id = $categorias[$i]->rubro_id;
            }else{
                $rubro_id = null;
            }


            // Creamos una bandera para controlar si se ha modificado algún dato.
            $bandera = false;

            // Actualización parcial de campos.
            /*if ($nombre != null && $nombre!='')
            {
                $aux = \App\Categoria::where('nombre', $nombre)
                ->where('id', '<>', $categoria->id)->get();

                if(count($aux)!=0){
                   // Devolvemos un código 409 Conflict. 
                    return response()->json(['error'=>'Ya existe otra categoría con el nombre '.$nombre.'.'], 409);
                }

                $categoria->nombre = $nombre;
                $bandera=true;
            }

            if ($codigo != null && $codigo!='')
            {
                $aux = \App\Categoria::where('codigo', $request->input('codigo'))
                ->where('id', '<>', $categoria->id)->get();

                if(count($aux)!=0){
                   // Devolvemos un código 409 Conflict. 
                    return response()->json(['error'=>'Ya existe otra categoría con el codigo '.$codigo.'.'], 409);
                }

                $categoria->codigo = $codigo;
                $bandera=true;
            }*/

            if ($tipo_id != null && $tipo_id!='')
            {
                $aux = \App\Tipo::find($tipo_id);
                
                if(!$aux){
                   // Devolvemos un código 409 Conflict. 
                    return response()->json(['error'=>'No existe el tipo con id '.$tipo_id.'.'], 409);
                }

                $categoria->tipo_id = $tipo_id;
                $bandera=true;
            }

            if ($rubro_id != null && $rubro_id!='')
            {
                $aux = \App\Rubro::find($rubro_id);
                
                if(!$aux){
                   // Devolvemos un código 409 Conflict. 
                    return response()->json(['error'=>'No existe el rubro con id '.$rubro_id.'.'], 409);
                }

                $categoria->rubro_id = $rubro_id;
                $bandera=true;
            }

            if ($bandera)
            {
                // Almacenamos en la base de datos el registro.
                if ($categoria->save()) {
                    
                    //continue;
                    //return response()->json(['message'=>'Categoría(s) editada(s) con éxito.'], 200);
                    
                }else{
                    return response()->json(['error'=>'Error al actualizar la categoría con id '.$categoria->id], 500);
                }
                
            }
            
        } 
        return $categoria;
         /*if ($bandera) {
            if (Cache::has('categorias'))
            {
                //Borrar elemento de la cache
                Cache::forget('categorias');
            }
        }*/

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Comprobamos si la categoria existe o no.
        $categoria=\App\Categoria::find($id);

        if (count($categoria)==0)
        {
            // Devolvemos error codigo http 404
            return response()->json(['error'=>'No existe la categoría con id '.$id], 404);
        }
       
        $productos = $categoria->productos;
        $stockDepartamentos = $categoria->stockDepartamentos;
        $stock = $categoria->stock;

        if (sizeof($productos) > 0 || sizeof($stockDepartamentos) > 0 || sizeof($stock) > 0)
        {
            // Devolvemos un código 409 Conflict. 
            return response()->json(['error'=>'Esta categoría no puede ser eliminada porque posee productos asociados.'], 409);
        }

        // Eliminamos la categoria si no tiene relaciones.
        $categoria->delete();

        if (Cache::has('categorias'))
        {
            //Borrar elemento de la cache
            Cache::forget('categorias');
        }

        return response()->json(['message'=>'Se ha eliminado correctamente la categoría.'], 200);
    }
}
