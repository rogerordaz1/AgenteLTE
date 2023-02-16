<?php

namespace App\Http\Controllers;

use SimpleCSV;
use App\Models\Agente;
use App\Models\Cliente;
use App\Models\Factura;



use App\Models\XmlFile;
use Shuchkin\SimpleXLS;
use Shuchkin\SimpleXLSX;
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
                $array = explode('.', $nombreArchivo);
                $ext = end($array);
                $fileExists  = file_exists(public_path('/storage/files/' . $nombreArchivo));
                if ($ext == 'xml' || $ext == 'xsd') {

                    if (Storage::putFileAs('/public/files',  $file, $nombreArchivo)) {
                        // if ($fileExists == false) {

                        $clientesXML  =  simplexml_load_file($file);

                        $clientesArray = [];

                        foreach ($clientesXML as $cliente) {

                            if ($cliente->ID_SECTOR != 'RT') {
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




    public function facturas(Request $request)
    {
        // $validated = $request->validate([
        //     'file' => 'required|mimes:xml,xsd|max:2048'
        // ]);
         $max_size = (int)ini_get('upload_max_filesize') * 10240;

        $files = $request->file('file');

        if ($request->hasFile('file')) {

            foreach ($files as $file) {

                $nombreArchivo = $file->getClientOriginalName();
                $array = explode('.', $nombreArchivo);
                $ext = end($array);

                if ($ext == 'xml' || $ext == 'xsd') {
                    if (Storage::putFileAs('/public/files',  $file, $nombreArchivo)) {

                        $facturasXML  =  simplexml_load_file($file);
                        $facturasJson = json_encode($facturasXML);
                        $facturasArray = json_decode($facturasJson, true);

                        $facturasArrayToDB = [];

                        foreach ($facturasArray['ROW'] as $factura1) {
                            if ($factura1['SECTOR'] != 'RT') {


                                $agrupacion = [];
                                foreach ($facturasArray['ROW'] as $factura2) {
                                    if ($factura1['AGRUPACION'] == $factura2['AGRUPACION']) {
                                        array_push($agrupacion, $factura2);
                                    }
                                }
                                $total = 0;
                                $servicio = '';
                                foreach ($agrupacion as $item) {
                                    if ($item['SERVICIO'] != '') {
                                        $servicio = $item['SERVICIO'];
                                    }
                                    $floatTotal = floatval($item['TOTAL']);
                                    $total = $total + $floatTotal;
                                }
                                $cliente = Cliente::where('servicio', $servicio)->get();
                                if ($cliente->count() == 1) {

                                    Factura::firstOrCreate([
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
                        }


                        // try {
                        //Factura::insert($facturasArrayToDB);
                        // } catch (\Throwable $th) {
                        //     Alert::error('Error', 'Ya existe una factura con ese id en el archivo: ' . $nombreArchivo);
                        //     unlink(public_path('/storage/files/' . $nombreArchivo));
                        //     return back();
                        // }


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
                                toast('Hay clientes que pagan servicios de otras provincias','info');
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