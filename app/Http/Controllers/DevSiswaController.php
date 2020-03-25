<?php

namespace App\Http\Controllers;

use App\DevSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\Controller;

class DevSiswaController extends Controller
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
        $siswa = DevSiswa::all();
        
        if(count($siswa) > 0){ //mengecek apakah data kosong atau tidak
            $success['status'] = true;
            $success['data'] = $siswa;
            $success['message'] = "Success!";
            return response()->json(['success'=>$success], $this->successStatus);     
        }
        else{
            $success['message'] = "Data Kosong!";
            $success['status'] = true;
            return response()->json(['success'=>$success], $this->successStatus);
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
            'nim' => 'required',
            'nama' => 'required',
            'kode_jur' => 'required',
            'kode_lokasi' => 'required',
        ]);

        if(DevSiswa::create($request->all())){
            $success['status'] = true;
            $success['message'] = "Data siswa berhasil disimpan";
            return response()->json($success, $this->successStatus);
        }else{
            $success['status'] = false;
            $success['message'] = "Data siswa gagal disimpan";
            return response()->json($success, $this->successStatus);
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DevSiswa  $DevSiswa
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        $siswa = DevSiswa::where('nim',$nim)->get();
        
        if(count($siswa) > 0){ //mengecek apakah data kosong atau tidak
            $success['status'] = true;
            $success['data'] = $siswa;
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
     * @param  \App\DevSiswa  $DevSiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(DevSiswa $DevSiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DevSiswa  $DevSiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        $this->validate($request, [
            'nim' => 'required',
            'nama' => 'required',
            'kode_jur' => 'required',
            'kode_lokasi' => 'required',
        ]);

        $res = DevSiswa::where('nim',$nim)
                ->update([
                    'kode_lokasi' => $request->kode_lokasi,
                    'nama' => $request->nama,
                    'kode_jur' => $request->kode_jur,
                ]);

        if($res){ //mengecek apakah data kosong atau tidak
            $success['status'] = true;
            $success['message'] = "Data Siswa berhasil diubah";
            return response()->json($success, $this->successStatus);     
        }
        else{
            $success['status'] = false;
            $success['message'] = "Data Siswa gagal diubah";
            return response()->json($success, $this->successStatus);     
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DevSiswa  $DevSiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        $siswa = DevSiswa::find($nim);
        if($siswa->delete()){ //mengecek apakah data kosong atau tidak
            $success['status'] = true;
            $success['message'] = "Data Siswa berhasil dihapus";
            return response()->json($success, $this->successStatus);     
        }
        else{
            $success['status'] = false;
            $success['message'] = "Data Siswa gagal dihapus";
            return response()->json($success, $this->successStatus);     
        }
    }

}
