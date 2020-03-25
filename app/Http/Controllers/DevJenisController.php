<?php

namespace App\Http\Controllers;

use App\DevJenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\Controller;

class DevJenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public $successStatus = 200;

    public function index()
    {
        $jenis = DevJenis::all();
        
        if(count($jenis) > 0){ //mengecek apakah data kosong atau tidak
            $success['status'] = true;
            $success['data'] = $jenis;
            $success['message'] = "Success!";
            return response()->json($success, $this->successStatus);     
        }
        else{
            $success['message'] = "Data Kosong!";
            $success['status'] = true;
            return response()->json($success, $this->successStatus);
        }
        
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
    {
        $this->validate($request, [
            'kode_jenis' => 'required',
            'nama' => 'required',
            'kode_lokasi' => 'required',
        ]);

        if(DevJenis::create($request->all())){
            $success['status'] = true;
            $success['message'] = "Data Jenis berhasil disimpan";
            return response()->json($success, $this->successStatus);
        }else{
            $success['status'] = false;
            $success['message'] = "Data Jenis gagal disimpan";
            return response()->json($success, $this->successStatus);
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DevJenis  $devjenis
     * @return \Illuminate\Http\Response
     */
    public function show($kode_jenis)
    {
        $jenis = DevJenis::where('kode_jenis',$kode_jenis)->get();
        
        if(count($jenis) > 0){ //mengecek apakah data kosong atau tidak
            $success['status'] = true;
            $success['data'] = $jenis;
            $success['message'] = "Success!";
            return response()->json($success, $this->successStatus);     
        }
        else{
            $success['message'] = "Data Tidak ditemukan!";
            $success['status'] = false;
            return response()->json($success, $this->successStatus);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DevJenis  $devjenis
     * @return \Illuminate\Http\Response
     */
    public function edit(Devjenis $devjenis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DevJenis  $devjenis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kode_jenis)
    {
        $this->validate($request, [
            'kode_jenis' => 'required',
            'nama' => 'required',
            'kode_lokasi' => 'required',
        ]);

        $res = DevJenis::where('kode_jenis',$kode_jenis)
                ->update([
                    'kode_lokasi' => $request->kode_lokasi,
                    'nama' => $request->nama,
                ]);

        if($res){ //mengecek apakah data kosong atau tidak
            $success['status'] = true;
            $success['message'] = "Data Jenis berhasil diubah";
            return response()->json($success, $this->successStatus);     
        }
        else{
            $success['status'] = false;
            $success['message'] = "Data Jenis gagal diubah";
            return response()->json($success, $this->successStatus);     
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DevJenis  $devJenis
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode_jenis)
    {
        $jenis = DevJenis::find($kode_jenis);
        if($jenis->delete()){ //mengecek apakah data kosong atau tidak
            $success['status'] = true;
            $success['message'] = "Data Jenis berhasil dihapus";
            return response()->json($success, $this->successStatus);     
        }
        else{
            $success['status'] = false;
            $success['message'] = "Data Jenis gagal dihapus";
            return response()->json($success, $this->successStatus);     
        }
    }

}
