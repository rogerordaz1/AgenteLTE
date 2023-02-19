<?php

namespace App\Http\Controllers;

use SimpleCSV;
use App\Models\Agente;
use App\Models\Cliente;
use App\Models\Factura;



use App\Models\XmlFile;
use Shuchkin\SimpleXLS;
use Shuchkin\SimpleXLSX;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class XmlFileController extends Controller
{


    public function index()
    {
        return view('files.index');
    }


    public function clientes(Request $request)
    {

        // $validated = $request->validate([
        //     'file' => 'required|mimes:xml,xsd|max:2048'
        // ]);


        $files = $request->file('file');

        if ($request->hasFile('file')) {

            foreach ($files as $file) {

                $nombreArchivo = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();

                $fileExists  = file_exists(public_path('/storage/files/' . $nombreArchivo));
                if ($ext == 'xml' || $ext == 'xsd') {

                    if (Storage::putFileAs('/public/files',  $file, $nombreArchivo)) {
                        // if ($fileExists == false) {

                        $clientesXML  =  simplexml_load_file($file);

                        $clientesArray = [];

                        foreach ($clientesXML as $cliente) {

                            if ($cliente->ID_SECTOR == 'RT') {
                                continue;
                            }

                            array_push($clientesArray, [
                                'id_oficina_comercial' => $cliente->ID_OFICINA_COMERCIAL,
                                'servicio' => $cliente->SERVICIO,
                                'agrupacion' => $cliente->ID_AGRUPACION,
                                'sector' => $cliente->ID_SECTOR,
                                'nombre' => $cliente->NOMBRE_CLIENTE,
                                'direccion' => $cliente->DIRECCION_POSTAL,
                                'cuenta_bancaria' => $cliente->CUENTA_BANCARIA,
                                'fecha_alta' => $cliente->FECHA_ALTA
                            ]);
                        }
                        try {
                            $chunked_new_record_array = array_chunk($clientesArray, 6500, true);

                            foreach ($chunked_new_record_array as $new_record_chunk) {
                                Cliente::insert($new_record_chunk);
                            }
                        } catch (\Throwable $th) {
                            Alert::error('Error', 'Ya existe un usuario con ese id en el archivo: ' . $nombreArchivo);
                            unlink(public_path('/storage/files/' . $nombreArchivo));
                            return back();
                        }


                        XmlFile::create([
                            'name' => $nombreArchivo,
                        ]);
                        // }

                        unlink(public_path('/storage/files/' . $nombreArchivo));
                    }
                } else {
                    Alert::error('Error', 'EL archivo seleccionado no es un xml o xsd: ' . $nombreArchivo);
                    return back();
                }
            }
            Alert::success('Subido', 'Los achivos se han subido correctamente');
            return back();
        } else {
            Alert::error('Error', 'Debe subir al menos 1 archivo');
            return back();
        }
    }




    public function facturass(Request $request)
    {
        $files = $request->file('file');

        if ($request->hasFile('file')) {

            foreach ($files as $file) {

                $nombreArchivo = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();

                if (!in_array($ext, ['xml', 'xsd'])) {
                    Alert::error('Error', 'EL archivo seleccionado no es un xml o xsd: ' . $nombreArchivo);
                    return back();
                }

                if (!Storage::putFileAs('/public/files', $file, $nombreArchivo)) {
                    Alert::error('Error', 'No se pudo guardar el archivo: ' . $nombreArchivo);
                    return back();
                }




                $facturasXML  =  simplexml_load_file($file);
                $facturasArray = json_decode(json_encode($facturasXML), true)['ROW'] ?? [];

                $facturasArrayToDB = [];



                foreach ($facturasArray as $factura1) {
                    if ($factura1['SECTOR'] != 'RT') {


                        $agrupacion = [];
                        foreach ($facturasArray as $factura2) {
                            if ($factura1['AGRUPACION'] == $factura2['AGRUPACION']) {
                                array_push($agrupacion, $factura2);
                            }
                        }

                        $servicio = '';
                        $total = 0;
                        foreach ($agrupacion as $item) {
                            $total = array_sum(array_column($item, 'TOTAL'));

                            if ($item['SERVICIO'] != '') {
                                $servicio = $item['SERVICIO'];
                            }
                        }

                        array_push($facturasArrayToDB,  [
                            'oficina'          => gettype($factura1['OFICINA']) == 'array' ? '' : $factura1['OFICINA'],
                            'agrupacion'       => gettype($factura1['AGRUPACION']) == 'array' ? '' : $factura1['AGRUPACION'],
                            'cuenta'           => gettype($factura1['CUENTA']) == 'array' ? '' : $factura1['CUENTA'],
                            'no_factura'       => gettype($factura1['NO_FACTURA']) == 'array' ? '' : $factura1['NO_FACTURA'],
                            'nombre_cliente'   => gettype($factura1['NOMBRE']) == 'array' ? '' : $factura1['NOMBRE'],
                            'servicio_cliente' => gettype($servicio) == 'array' ? '' : $servicio,
                            'total'            => $total,
                        ]);
                    }
                }

                $facturasArrayToDBNODUPL = array_unique($facturasArrayToDB, SORT_REGULAR);
                try {
                    $chunked_new_record_array = array_chunk($facturasArrayToDBNODUPL, 3000, true);

                    foreach ($chunked_new_record_array as $new_record_chunk) {
                        Factura::insert($new_record_chunk);
                    }
                } catch (\Throwable $th) {
                    Alert::error('Error', 'Ya existe una factura con ese id en el archivo: ' . $nombreArchivo);
                    unlink(public_path('/storage/files/' . $nombreArchivo));
                    return back();
                }


                XmlFile::create([
                    'name' => $nombreArchivo,
                ]);
                // }

                unlink(public_path('/storage/files/' . $nombreArchivo));
            }

            Alert::success('Subido', 'Los achivos se han subido correctamente');
            return back();
        } else {
            Alert::error('Error', 'Debe subir al menos 1 archivo');
            return back();
        }
    }
    public function facturas(Request $request)
    {
        $files = $request->file('file');

        if ($request->hasFile('file')) {

            foreach ($files as $file) {

                $nombreArchivo = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();

                if (!in_array($ext, ['xml', 'xsd'])) {
                    Alert::error('Error', 'EL archivo seleccionado no es un xml o xsd: ' . $nombreArchivo);
                    return back();
                }
                if (!Storage::putFileAs('/public/files', $file, $nombreArchivo)) {
                    Alert::error('Error', 'No se pudo guardar el archivo: ' . $nombreArchivo);
                    return back();
                }
                $facturasXML  =  simplexml_load_file($file);
                $facturasArray = json_decode(json_encode($facturasXML), true)['ROW'] ?? [];
                $facturasArrayToDB = [];
                sort($facturasArray);
                for ($i = 0; $i < count($facturasArray); $i++) {
                    $indice = 0;
                    if ($facturasArray[$i]['SECTOR'] == 'RT') {
                        continue;
                    }
                    $agrupacion = [];
                    for ($j = $i; $j < count($facturasArray); $j++) {
                        if ($facturasArray[$i]['AGRUPACION'] == $facturasArray[$j]['AGRUPACION']) {
                            array_push($agrupacion, $facturasArray[$j]);
                            $indice++;
                        } else {
                            $i += $indice - 1;
                            break;
                        }
                    }
                    $servicio = '';
                    $total = array_sum(array_column($agrupacion, 'TOTAL'));
                    foreach ($agrupacion as $item) {
                        if (isset($item['SERVICIO']) && !empty($item['SERVICIO'])) {
                            if ($item['ACTIVO'] == "T" || $item['ACTIVO'] == "F") {
                                continue;
                            }
                            $servicio = $item['SERVICIO'] ?? null;
                        }
                    }
                    if ($servicio == '') {
                        continue;
                    }
                    array_push($facturasArrayToDB,  [
                        'oficina'          => gettype($facturasArray[$i]['OFICINA'])    == 'array' ? '' : $facturasArray[$i]['OFICINA'],
                        'agrupacion'       => gettype($facturasArray[$i]['AGRUPACION']) == 'array' ? '' : $facturasArray[$i]['AGRUPACION'],
                        'cuenta'           => gettype($facturasArray[$i]['CUENTA'])     == 'array' ? '' : $facturasArray[$i]['CUENTA'],
                        'no_factura'       => gettype($facturasArray[$i]['NO_FACTURA']) == 'array' ? '' : $facturasArray[$i]['NO_FACTURA'],
                        'nombre_cliente'   => gettype($facturasArray[$i]['NOMBRE'])     == 'array' ? '' : $facturasArray[$i]['NOMBRE'],
                        'servicio_cliente' => $servicio,
                        'total'            => $total,
                    ]);
                }
                $facturasArrayToDBNODUPL = array_unique($facturasArrayToDB, SORT_REGULAR);
                 try {
                $chunked_new_record_array = array_chunk($facturasArrayToDBNODUPL, 3000, true);

                foreach ($chunked_new_record_array as $new_record_chunk) {
                    Factura::insert($new_record_chunk);
                }
                 } catch (\Throwable $th) {
                    Alert::error('Error', 'Ocurrio un error a la hora de guardar en la base de datos ' . $nombreArchivo);
                    unlink(public_path('/storage/files/' . $nombreArchivo));
                    return back();
                 }


                XmlFile::create([
                    'name' => $nombreArchivo,
                ]);
                

                unlink(public_path('/storage/files/' . $nombreArchivo));
            }

            Alert::success('Subido', 'Los achivos se han subido correctamente');
            return back();
        } else {
            Alert::error('Error', 'Debe subir al menos 1 archivo');
            return back();
        }
    }






    public function facturasas(Request $request)
    {

        $request->validate([
            'file' => 'required|array',
            'file.*' => 'required|mimes:xml,xsd|max:60000000',
        ]);

        foreach ($request->file('file') as $file) {
            $nombreArchivo = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            if (!in_array($extension, ['xml', 'xsd'])) {
                Alert::error('Error', 'El archivo seleccionado no es un xml o xsd: ' . $nombreArchivo);
                continue;
            }
            $filePath = $file->store('public/files');
            $facturasXML = simplexml_load_file($file);
            $facturasArray = json_decode(json_encode($facturasXML), true)['ROW'] ?? [];
            //aqui esta el array organizado

            $facturasArrayToDB = [];


            $agrupados = $this->agruparPor($facturasArray, 'AGRUPACION');
            $clientes = Cliente::where('id_oficina_comercial', $facturasArray[0]['OFICINA'])->get();





            foreach ($agrupados as $item) {
                $total = array_sum(array_column($item, 'TOTAL'));

                $servicio = null;
                foreach ($item as $f) {
                    if ($f['ESTADO'] == 'F') {
                        continue;
                    }

                    if (isset($f['SERVICIO']) && !empty($f['SERVICIO'])) {
                        $servicio = $f['SERVICIO'] ?? null;
                    }

                    $phoneToFind = $f["SERVICIO"];


                    $facturaToDB = [
                        'oficina'          => gettype($f['OFICINA']) == 'array' ? '' : $f['OFICINA'],
                        'agrupacion'       => gettype($f['AGRUPACION']) == 'array' ? '' : $f['AGRUPACION'],
                        'cuenta'           => gettype($f['CUENTA']) == 'array' ? '' : $f['CUENTA'],
                        'no_factura'       => gettype($f['NO_FACTURA']) == 'array' ? '' : $f['NO_FACTURA'],
                        'nombre_cliente'   => gettype($f['NOMBRE']) == 'array' ? '' : $f['NOMBRE'],
                        'servicio_cliente' => $servicio,
                        'total' => $total,
                    ];
                    // Agregar el registro al array
                    $facturasArrayToDB[] = $facturaToDB;
                    $facturaToDBNoDuplicate = array_unique($facturasArrayToDB, SORT_REGULAR);
                }
            }

            Factura::insert($facturaToDBNoDuplicate);
        }
    }


    private  function agruparPor($arr, $llave)
    {
        return array_reduce($arr, function ($resultado, $elemento) use ($llave) {
            $valorLlave = $elemento[$llave];
            if (!isset($resultado[$valorLlave])) {
                $resultado[$valorLlave] = [];
            }
            $resultado[$valorLlave][] = $elemento;
            return $resultado;
        }, []);
    }



    public function agentes(Request $request)
    {

        $files = $request->file('file');
        if ($request->hasFile('file')) {
            foreach ($files as $file) {
                $nombreArchivo = $file->getClientOriginalName();
                $array = explode('.', $nombreArchivo);
                $ext = end($array);
                if ($ext == 'xlsx') {
                    if ($xls = SimpleXLSX::parse($file)) {
                        $array =  $xls->rows();
                        array_splice($array, 0, 3);
                        foreach ($array as $item) {
                            $id_oficina_comercial =  $item[5];
                            trim($id_oficina_comercial);
                            $id_oficina = substr($id_oficina_comercial, 1, 2);
                            // print_r($id_oficina);


                            // print_r($id_oficina_comercial);
                            $agente = Agente::firstOrCreate([
                                'id_oficina_comercial' => $id_oficina,
                                'nombre' => $item[7],
                            ]);
                            try {
                                $cliente  =  Cliente::where('servicio', $item[4])->firstOrFail();
                            } catch (\Throwable $th) {
                                toast('Hay clientes que pagan servicios de otras provincias', 'info');
                            }
                            //->update([
                            //     'id_agente' => $agente->id,
                            // ]);


                        }
                    } else {
                        echo SimpleXLS::parseError();
                    }
                } else {
                    Alert::error('Error', 'EL archivo seleccionado no es un xls: ' . $nombreArchivo);
                    return back();
                }
            }
            Alert::success('Subido', 'Los achivos se han subido correctamente');
            return back();
        } else {
            Alert::error('Error', 'Debe subir al menos 1 archivo');
            return back();
        }
    }
}










                
              

                


               

            
               
            

           
     
        
    
   
      
    

    


// Array ( [0] => SECTOR [1] => IMPORTE FACTURADO [2] => C.IDENT. [3] => MONEDA [4] => NOMBRE SERVICIO [5] => DESCRIPCION [6] => IMPORTE COBRADO [7] => CLIENTE [8] => IMPORTE COMISION
