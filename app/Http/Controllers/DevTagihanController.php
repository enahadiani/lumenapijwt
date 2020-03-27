<?php

namespace App\Http\Controllers;

// use App\DevSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\Controller;

class DevTagihanController extends Controller
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
        $tgh = DB::select("select a.no_tagihan,a.nim,b.nama,a.tanggal,a.keterangan,a.periode 
        from dev_tagihan_m a 
        left join dev_siswa b on a.nim=b.nim and a.kode_lokasi=b.kode_lokasi
        where a.kode_lokasi='99'");
        $tgh = json_decode(json_encode($tgh),true);
        // $siswa = DevSiswa::all();
        
        if(count($tgh) > 0){ //mengecek apakah data kosong atau tidak
            $success['status'] = true;
            $success['data'] = $tgh;
            $success['message'] = "Success!";
            
            return response()->json(['success'=>$success], $this->successStatus);     
        }
        else{
            $success['message'] = "Data Kosong!";
            $success['status'] = true;
            
            return response()->json(['success'=>$success], $this->successStatus);
        }
        
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

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
            'kode_lokasi' => 'required',
            'keterangan' => 'required',
            'tanggal'=>'required',
            'periode'=>'required',
        ]);

        $str_format="0000";
        $periode=date('Y').date('m');
        $per=date('y').date('m');
        $prefix=$request['kode_lokasi']."-TG".$per.".";

        $query = DB::select("select right(ifnull(max(no_tagihan),'".$prefix."0000'),".strlen($str_format).")+1 as id from dev_tagihan_m where no_tagihan like '$prefix%'");
        $query = json_decode(json_encode($query),true);

        $id = $prefix.str_pad($query[0]['id'], strlen($str_format), $str_format, STR_PAD_LEFT);

        DB::beginTransaction();
        
        try {
            $ins = DB::insert('insert into dev_tagihan_m (no_tagihan,kode_lokasi,nim,tanggal,keterangan,periode)  values (?, ?, ?, ?, ?, ?)', [$id, $request->input('kode_lokasi'),$request->input('nim'),$request->input('tanggal'),$request->input('keterangan'),$request->input('periode')]);
    
            $detail = true; $ins2 = array();
            for($i=0;$i<count($request->input('kode_jenis'));$i++){
    
                $ins2[$i] = DB::insert('insert into dev_tagihan_d (no_tagihan,kode_lokasi,kode_jenis,nilai)  values (?, ?, ?, ?)', array($id,$request->input('kode_lokasi'),$request->input('kode_jenis')[$i],$request->input('nilai')[$i]));
                if(!$ins2[$i]){
                    $detail = false;
                    break;
                }
    
            }   
            DB::commit();
            $success['status'] = true;
            $success['id'] = $id;
            $success['message'] = "Data siswa berhasil disimpan";
            return response()->json($success, $this->successStatus);
        } catch (\Throwable $e) {
            DB::rollback();
            $success['status'] = false;
            $success['message'] = "Data siswa gagal disimpan ".$e;
            return response()->json($success, $this->successStatus);
        }
        
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\DevSiswa  $DevSiswa
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($nim)
    // {
    //     $siswa = DevSiswa::where('nim',$nim)->get();
        
    //     if(count($siswa) > 0){ //mengecek apakah data kosong atau tidak
    //         $success['status'] = true;
    //         $success['data'] = $siswa;
    //         $success['message'] = "Success!";
    //         return response()->json($success, $this->successStatus);     
    //     }
    //     else{
    //         $success['message'] = "Data Tidak ditemukan!";
    //         $success['status'] = false;
    //         return response()->json($success, $this->successStatus);
    //     }
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\DevSiswa  $DevSiswa
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(DevSiswa $DevSiswa)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\DevSiswa  $DevSiswa
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $nim)
    // {
    //     $this->validate($request, [
    //         'nim' => 'required',
    //         'nama' => 'required',
    //         'kode_jur' => 'required',
    //         'kode_lokasi' => 'required',
    //     ]);

    //     $res = DevSiswa::where('nim',$nim)
    //             ->update([
    //                 'kode_lokasi' => $request->kode_lokasi,
    //                 'nama' => $request->nama,
    //                 'kode_jur' => $request->kode_jur,
    //             ]);

    //     if($res){ //mengecek apakah data kosong atau tidak
    //         $success['status'] = true;
    //         $success['message'] = "Data Siswa berhasil diubah";
    //         return response()->json($success, $this->successStatus);     
    //     }
    //     else{
    //         $success['status'] = false;
    //         $success['message'] = "Data Siswa gagal diubah";
    //         return response()->json($success, $this->successStatus);     
    //     }
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\DevSiswa  $DevSiswa
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($nim)
    // {
    //     $siswa = DevSiswa::find($nim);
    //     if($siswa->delete()){ //mengecek apakah data kosong atau tidak
    //         $success['status'] = true;
    //         $success['message'] = "Data Siswa berhasil dihapus";
    //         return response()->json($success, $this->successStatus);     
    //     }
    //     else{
    //         $success['status'] = false;
    //         $success['message'] = "Data Siswa gagal dihapus";
    //         return response()->json($success, $this->successStatus);     
    //     }
    // }

}
