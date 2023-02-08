<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\XmlFile;
use Illuminate\Http\Request;


class XmlFileController extends Controller
{
    public function index()
    {
        return view('files.index');
    }

    
    public function store(Request $request)
    {

        $name = $request->file('file')->getClientOriginalName();
        $path = $request->file('file')->store('public\files');
        $arrayPath = explode('public\files/', $path);
        $publicName = $arrayPath[1];
        $xmlDataString = file_get_contents(public_path('storage\files\\' . $publicName));
        $xmlObject = simplexml_load_string($xmlDataString);
        $json = json_encode($xmlObject);
        $phpDataArray = json_decode($json, true);
        if (count($phpDataArray['ROW']) > 0) {
            $dataArray = array();
            foreach ($phpDataArray['ROW'] as $index => $data) {
                $dataArray[] = [
                    "id_oficina_comercial" => $data['ID_OFICINA_COMERCIAL'],
                    "servicio"             => $data['SERVICIO'],
                    "sector"               => $data['ID_SECTOR'],
                    "nombre"               => $data['NOMBRE_CLIENTE'],
                    "direccion"            => $data['DIRECCION_POSTAL'],
                    "cuenta_bancaria"      => gettype($data['CUENTA_BANCARIA']) == 'array' ? '' : $data['CUENTA_BANCARIA'],
                    "fecha_alta"           => $data['FECHA_ALTA'],
                ];
            }
            try {
                Cliente::insert($dataArray);
                return back()->with('success', 'Data saved successfully!');
            } catch (\Throwable $th) {
                return back()->with('fail', 'Data Faild!');
            }
        }
    }
}
