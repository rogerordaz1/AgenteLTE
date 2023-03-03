<?php

namespace App\Http\Controllers;

use SimpleCSV;
use App\Models\Agente;
use App\Models\Cliente;
use App\Models\Factura;
use App\Models\NAgredado;
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

    public function __construct()
    {
        $this->middleware('can:dashboard.xmlfile')->only('index');

        $this->middleware('can:dashboard.file.clientes')->only('clientes');
        $this->middleware('can:dashboard.file.facturas')->only('facturas');
        $this->middleware('can:dashboard.file.agentes')->only('agentes');
        $this->middleware('can:dashboard.file.vaciarFacturas')->only('vaciarFacturas');
    }
    public function index()
    {
        return view('files.index');
    }


    public function clientes(Request $request)
    {
        //  Hacer la funcion manual de eliminar el cliente....
        $files = $request->file('files');

        if (!$request->hasFile('files')) {
            return response()->json([
                'message' => 'Debe subir al menos 1 archivo.',
                'header' => 'Upss!!!',
                'icon' => 'error',
            ], 400);
        }

        foreach ($files as $file) {

            $nombreArchivo = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            if (!in_array($ext, ['xml', 'xsd'])) {
                return response()->json([
                    'message' => 'EL archivo seleccionado no es un xml o xsd' . $nombreArchivo,
                    'header' => 'Upss!!!',
                    'icon' => 'error',
                ]);
            }

            $clientesXML  =  simplexml_load_file($file);
            $clientesArray = [];
            foreach ($clientesXML as $cliente) {

                $clienteEspecifico = Cliente::where('servicio', $cliente->SERVICIO)->first();
                if ($clienteEspecifico) {
                    continue;
                }


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
                $chunked_new_record_array = array_chunk($clientesArray, 6000, true);

                foreach ($chunked_new_record_array as $new_record_chunk) {
                    Cliente::insert($new_record_chunk);
                }
            } catch (\Throwable $th) {

                return response()->json([
                    'message' => 'Occurio algun error cuando se trato de guardar en la BD el archivo: ' . $nombreArchivo,
                    'header' => 'Upss!!!',
                    'icon' => 'error',
                ]);
            }

            return response()->json([
                'message' => 'Los achivos se han subido correctamente',
                'header' => 'Operacion Exitosa',
                'icon' => 'success',
            ]);
        }
    }





    public function facturas(Request $request)
    {
        $files = $request->file('files');

        if (!$request->hasFile('files')) {
            return response()->json([
                'message' => 'Debe subir al menos 1 archivo.',
                'header' => 'Upss!!!',
                'icon' => 'error',
            ], 400);
        }

        // por si en algun mometo hay que guardar el archivo    $filePath = $file->store('public/files');
        foreach ($files as $file) {

            $nombreArchivo = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();

            if (!in_array($ext, ['xml', 'xsd'])) {
                return response()->json([
                    'message' => 'EL archivo seleccionado no es un xml o xsd' . $nombreArchivo,
                    'header' => 'Upss!!!',
                    'icon' => 'error',
                ]);
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
                $atraso = array_sum(array_column($agrupacion, 'ATRASOS'));
                foreach ($agrupacion as $item) {

                    if (isset($item['SERVICIO']) && !empty($item['SERVICIO'])) {
                        if ($item['ACTIVO'] == "T" || $item['ACTIVO'] == "F") {
                            // Hay que prebaor este  codigo de aqui abajo a ver si sirve asi me imagino que si...
                            $cliente = Cliente::where('servicio', $item['ACTIVO'])->first();
                            if (!empty($cliente)) {
                                $cliente->delete();
                            }
                            continue;
                        }
                        $servicio = $item['SERVICIO'] ?? null;
                    }
                }
                if ($servicio == '') {
                    continue;
                }


                // Anadir una validacion para verificar que la factura no c encuentre en la database...
                $facturaExiste = Factura::where('no_factura', $facturasArray[$i]['NO_FACTURA'])->first();
                if ($facturaExiste) {
                    // si quiero hacerlo nada mas que encuentre una factura puedo poner el break;
                    break;
                }
                array_push($facturasArrayToDB,  [
                    'oficina'          => gettype($facturasArray[$i]['OFICINA'])    == 'array' ? '' : $facturasArray[$i]['OFICINA'],
                    'agrupacion'       => gettype($facturasArray[$i]['AGRUPACION']) == 'array' ? '' : $facturasArray[$i]['AGRUPACION'],
                    'cuenta'           => gettype($facturasArray[$i]['CUENTA'])     == 'array' ? '' : $facturasArray[$i]['CUENTA'],
                    'no_factura'       => gettype($facturasArray[$i]['NO_FACTURA']) == 'array' ? '' : $facturasArray[$i]['NO_FACTURA'],
                    'nombre_cliente'   => gettype($facturasArray[$i]['NOMBRE'])     == 'array' ? '' : $facturasArray[$i]['NOMBRE'],
                    'servicio_cliente' => $servicio,
                    'atraso'           => $atraso,
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
                return response()->json([
                    'message' => 'Occurio algun error cuando se trato de guardar en la BD el archivo: ' . $nombreArchivo,
                    'header' => 'Upss!!!',
                    'icon' => 'error',
                ]);
            }
        }

        //Esto es para eliminar los clientes que no tengan factura asociados en la database...
        $clientes = Cliente::all();
        foreach ($clientes as $key => $value) {
           if (!$value->factura) {
            $value->delete();
           }
        }

        return response()->json([
            'message' => 'Los achivos se han subido correctamente',
            'header' => 'Operacion Exitosa',
            'icon' => 'success',
        ]);
    }


    public function agentes(Request $request)
    {

        $files = $request->file('file');

        if (!$request->hasFile('file')) {
            return response()->json([
                'message' => 'Debe subir al menos 1 archivo.',
                'header' => 'Upss!!!',
                'icon' => 'error',
            ], 400);
        }
        foreach ($files as $file) {

            $nombreArchivo = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();

            if (!in_array($ext, ['xlsx'])) {
                return response()->json([
                    'message' => 'EL archivo seleccionado no es un xlsx: ' . $nombreArchivo,
                    'header' => 'Upss!!!',
                    'icon' => 'error',
                ]);
            }
            if ($xls = SimpleXLSX::parse($file)) {
                $array =  $xls->rows();
                array_splice($array, 0, 3);
                foreach ($array as $item) {
                    $id_oficina_comercial =  $item[5];
                    trim($id_oficina_comercial);
                    $id_oficina = substr($id_oficina_comercial, 1, 2);

                    $agente = Agente::firstOrCreate([
                        'id_oficina_comercial' => $id_oficina,
                        'nombre' => $item[7],
                    ]);


                    $cliente  =  Cliente::where('servicio', $item[4])->first();

                    if (!empty($cliente)) {
                        $cliente->id_agente = $agente->id;
                        $cliente->save();
                    } else {

                        NAgredado::updateOrCreate([
                            'id_agente' => $agente->id,
                            'servicio' => $item[4],
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'message' => 'No se pudo procesar el archivo: ' . $nombreArchivo,
                    'header' => 'Upss!!!',
                    'icon' => 'error',
                ]);
            }
        }
        return response()->json([
            'message' => 'Los achivos se han subido correctamente',
            'header' => 'Operacion Exitosa',
            'icon' => 'success',
        ]);
    }


    public function vaciarFacturas(Request $request)
    {
        Factura::truncate();
        Alert::success('Vaciado Correctamente', 'las facturas se han eliminado correctamente');
        return back();
    }
}

































// Array ( [0] => SECTOR [1] => IMPORTE FACTURADO [2] => C.IDENT. [3] => MONEDA [4] => NOMBRE SERVICIO [5] => DESCRIPCION [6] => IMPORTE COBRADO [7] => CLIENTE [8] => IMPORTE COMISION
