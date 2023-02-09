<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
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


    public function store(Request $request)
    {

        $max_size = (int)ini_get('upload_max_filesize') * 10240;

        $files = $request->file('file');

        if ($request->hasFile('file')) {

            foreach ($files as $file) {
                $fileExists  = file_exists(public_path('/storage/files/' . $file->getClientOriginalName()));



                if (Storage::putFileAs('/public/files',  $file, $file->getClientOriginalName())) {
                    if ($fileExists == false) {
                        $clientes  =  simplexml_load_file($file);
                        foreach ($clientes as $cliente) {

                            // $user = Cliente::where('servicio', $cliente->SERVICIO)->get();

                            // if ($user->count() > 0) {
                            //     break;
                            // } else {
                                Cliente::create([
                                    'id_oficina_comercial' => $cliente->ID_OFICINA_COMERCIAL,
                                    'servicio' => $cliente->SERVICIO,
                                    'sector' => $cliente->ID_SECTOR,
                                    'nombre' => $cliente->NOMBRE_CLIENTE,
                                    'direccion' => $cliente->DIRECCION_POSTAL,
                                    'cuenta_bancaria' => $cliente->CUENTA_BANCARIA,
                                    'fecha_alta' => $cliente->FECHA_ALTA
                                ]);
                           // }
                        }
                        XmlFile::create([
                            'name' => $file->getClientOriginalName(),
                        ]);
                     }
                }
            }
            Alert::success('Subido', 'Los achivos se han subido correctamente');
            return back();
        } else {
            Alert::error('Error', 'Debe subir al menos 1 archivo');
            return back();
        }





        // $name = $request->file('file')->getClientOriginalName();
        // $path = $request->file('file')->store('public\files');
        // $arrayPath = explode('public\files/', $path);

        // $publicName = $arrayPath[1];

        // $xmlDataString = file_get_contents(public_path('storage\files\\' . $publicName));

        // $xmlObject = simplexml_load_string($xmlDataString);

        // $json = json_encode($xmlObject);
        // $phpDataArray = json_decode($json, true);
        //     if (count($phpDataArray['ROW']) > 0) {
        //         $dataArray = array();
        //         foreach ($phpDataArray['ROW'] as $index => $data) {

        //             $dataArray[] = [
        //                 "id_oficina_comercial" => $data['ID_OFICINA_COMERCIAL'],
        //                 "servicio"             => $data['SERVICIO'],
        //                 "sector"               => $data['ID_SECTOR'],
        //                 "nombre"               => $data['NOMBRE_CLIENTE'],
        //                 "direccion"            => $data['DIRECCION_POSTAL'],
        //                 "cuenta_bancaria"      => gettype($data['CUENTA_BANCARIA']) == 'array' ? '' : $data['CUENTA_BANCARIA'],
        //                 "fecha_alta"           => $data['FECHA_ALTA'],
        //             ];

        //         }
        //     try {
        //         Cliente::insert($dataArray);
        //         return back()->with('success', 'Data saved successfully!');
        //     } catch (\Throwable $th) {
        //         return back()->with('fail', 'Data Faild!');
        //     }
        // }
    }
}
