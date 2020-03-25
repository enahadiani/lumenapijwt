<?php

namespace App\Http\Controllers;

use App\DevJur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\Controller;

class DevJurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $successStatus = 200;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jur = DevJur::all();
        
        if(count($jur) > 0){ //mengecek apakah data kosong atau tidak
            $success['status'] = true;
            $success['data'] = $jur;
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
            'kode_jur' => 'required',
            'nama' => 'required',
            'kode_lokasi' => 'required',
        ]);

        if(DevJur::create($request->all())){
            $success['status'] = true;
            $success['message'] = "Data Jurusan berhasil disimpan";
            return response()->json($success, $this->successStatus);
        }else{
            $success['status'] = false;
            $success['message'] = "Data Jurusan gagal disimpan";
            return response()->json($success, $this->successStatus);
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DevJur  $devJur
     * @return \Illuminate\Http\Response
     */
    public function show($kode_jur)
    {
        $jur = DevJur::where('kode_jur',$kode_jur)->get();
        
        if(count($jur) > 0){ //mengecek apakah data kosong atau tidak
            $success['status'] = true;
            $success['data'] = $jur;
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
     * @param  \App\DevJur  $devJur
     * @return \Illuminate\Http\Response
     */
    public function edit(DevJur $devJur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DevJur  $devJur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kode_jur)
    {
        $this->validate($request, [
            'kode_jur' => 'required',
            'nama' => 'required',
            'kode_lokasi' => 'required',
        ]);

        $res = DevJur::where('kode_jur',$kode_jur)
                ->update([
                    'kode_lokasi' => $request->kode_lokasi,
                    'nama' => $request->nama,
                ]);

        if($res){ //mengecek apakah data kosong atau tidak
            $success['status'] = true;
            $success['message'] = "Data Jurusan berhasil diubah";
            return response()->json($success, $this->successStatus);     
        }
        else{
            $success['status'] = false;
            $success['message'] = "Data Jurusan gagal diubah";
            return response()->json($success, $this->successStatus);     
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DevJur  $devJur
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode_jur)
    {
        $jur = DevJur::find($kode_jur);
        if($jur->delete()){ //mengecek apakah data kosong atau tidak
            $success['status'] = true;
            $success['message'] = "Data Jurusan berhasil dihapus";
            return response()->json($success, $this->successStatus);     
        }
        else{
            $success['status'] = false;
            $success['message'] = "Data Jurusan gagal dihapus";
            return response()->json($success, $this->successStatus);     
        }
    }

}
