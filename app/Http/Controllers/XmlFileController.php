<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Factura;
use App\Models\XmlFile;
use Illuminate\Http\Request;
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
        $max_size = (int)ini_get('upload_max_filesize') * 10240;

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

                        $clientes  =  simplexml_load_file($file);



                        foreach ($clientes as $cliente) {
                            try {
                                Cliente::create([
                                    'id_oficina_comercial' => $cliente->ID_OFICINA_COMERCIAL,
                                    'servicio' => $cliente->SERVICIO,
                                    'agrupacion' => $cliente->ID_AGRUPACION,
                                    'sector' => $cliente->ID_SECTOR,
                                    'nombre' => $cliente->NOMBRE_CLIENTE,
                                    'direccion' => $cliente->DIRECCION_POSTAL,
                                    'cuenta_bancaria' => $cliente->CUENTA_BANCARIA,
                                    'fecha_alta' => $cliente->FECHA_ALTA
                                ]);
                            } catch (\Exception) {
                                Alert::error('Error', 'Ya existe un usuario con ese id en el archivo: ' . $nombreArchivo);
                                unlink(public_path('/storage/files/' . $nombreArchivo));
                                return back();
                            }
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
        // $max_size = (int)ini_get('upload_max_filesize') * 10240;

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
                        $facturasXML  =  simplexml_load_file($file);
                        $facturasJson = json_encode($facturasXML);
                        $facturasArray = json_decode($facturasJson, true);
                        foreach ($facturasArray['ROW'] as $factura1) {
                        
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
                                $factura = Factura::where('servicio_cliente', $servicio)->get();
                                if ($cliente->count() == 1) {
                                    if ($factura->count() == 0) {
                                        Factura::create([
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
                            

                            // } catch (\Exception) {
                            //     Alert::error('Error', 'Ya existe una factura con ese id en el archivo: ' . $nombreArchivo);
                            //     unlink(public_path('/storage/files/' . $nombreArchivo));
                            //     return back();
                            // }
                            // }
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
}
