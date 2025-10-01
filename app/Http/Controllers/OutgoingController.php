<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\ApiConfigurationTrait;

class OutgoingController extends Controller
{
    use ApiConfigurationTrait;

    /**
     * Constructor - inisialisasi konfigurasi API
     */
    public function __construct()
    {
        $this->initializeApiConfiguration();
    }

    /**
     * ✅ PERBAIKAN: Tambahkan userid ke view
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $fullnames = $request->session()->get('session_gitinventory_username');
        $userid = $request->session()->get('session_gitinventory_userid'); // ✅ TAMBAHAN
        $gitversions = $this->getVersionSafely();
        
        // ✅ PERBAIKAN: Sertakan userid dalam compact
        return view('admins.output', compact('gitversions', 'fullnames', 'userid'));
    }

    /**
     * Load data dengan pagination
     * 
     * @param Request $request
     * @param int $valjmlhal
     * @return void
     */
    public function loaddata(Request $request, $valjmlhal = 1)
    {
        $output = '';
        $jumlahDataPerHalaman = 10;
        $stdate = $request->get('stdate');
        $endate = $request->get('endate');
        $jnsdokbc = $request->get('jnsdokbc');
        $nodokbc = $request->get('nodokbc');
        $partno = $request->get('partno');

        // Gunakan method dari trait untuk API call
        $counts = $this->makeApiRequest('json_output_sync.php', [
            'valstdate' => $stdate,
            'valendate' => $endate,
            'valjnsdok' => $jnsdokbc,
            'valnodok' => $nodokbc,
            'valpartno' => $partno,
            'page' => 0,
            'limit' => 1
        ]);

        $totalcount = $counts['totalCount'] ?? 0;

        if ($totalcount > 0) {
            $jumlahHalaman = ceil($totalcount / $jumlahDataPerHalaman);
            $halamanAktif = intval($valjmlhal);
            $awalData = (($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman);

            // Ambil data dengan pagination
            $sql = $this->makeApiRequest('json_output_sync.php', [
                'valstdate' => $stdate,
                'valendate' => $endate,
                'valjnsdok' => $jnsdokbc,
                'valnodok' => $nodokbc,
                'valpartno' => $partno,
                'page' => $awalData,
                'limit' => $jumlahDataPerHalaman
            ]);
            
            $nomor = $awalData;
            foreach ($sql['rows'] as $rowdata) {
                $no = ++$nomor;
                $output .= $this->return_data($no, $rowdata);
            }
        } else {
            $jumlahHalaman = ceil($totalcount / $jumlahDataPerHalaman);
            $halamanAktif = 0;
            $awalData = (($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman) + 1;
            $output = '<tr><td class="text-center" colspan="16">No Data Found</td></tr>';
        }

        $data = [
            'table_data' => $output,
            'totalcount' => $totalcount,
            'halamanAktif' => $halamanAktif,
            'jumlahHalaman' => $jumlahHalaman
        ];
        
        echo json_encode($data);
    }

    public function return_data($no,$rowdata)
    {
        return '<tr>
                    <td align="right"><medium class="text-muted">'.$no.'</medium></td>
                    <td>'.$rowdata['jnsdokbc'].'</td>
                    <td>'.$rowdata['nodokbc'].'</td>
                    <td>'.$rowdata['datedokbc'].'</td>
                    <td>'.$rowdata['buktikirim'].'</td>
                    <td>'.$rowdata['datekirim'].'</td>
                    <td>'.$rowdata['buktiinvoice'].'</td>
                    <td>'.$rowdata['supplier'].'</td>
                    <td>'.$rowdata['partno'].'</td>
                    <td>'.$rowdata['partname'].'</td>
                    <td align="right">'.$rowdata['qty'].'</td>
                    <td>'.$rowdata['unit'].'</td>
                    <td>'.$rowdata['currency'].'</td>
                    <td align="right">'.$rowdata['price'].'</td>
                    </tr>';
                    // <td>'.$rowdata['dateinvoice'].'</td>
                    // <td>'.$rowdata['input_user'].'<br>'.$rowdata['input_date'].'</td>
    }

    //  ***
    //  pagination
    public function pagination(Request $request)
    {
        return $this->loaddata($request,$request->get('jumlahHalaman'));
        //  action ajax
        /* if($request->ajax())
        {
            //  variable
            $output     = '';
            $jumlahDataPerHalaman = 10;
            $valjmlhal  = $request->get('jumlahHalaman');
            $stdate     = $request->get('stdate');
            $endate     = $request->get('endate');
            $jnsdokbc   = $request->get('jnsdokbc');
            $nodokbc    = $request->get('nodokbc');
            $partno     = $request->get('partno');

            //  konfigurasi pagination
            $counts = DB::select("call sync_disp_output(0, 1, '{$stdate}', '{$endate}', '{$jnsdokbc}', '{$nodokbc}', '{$partno}');");
            if(empty($counts))
            {
                $totalcount = 0;
            }
            else
            {
                foreach($counts as &$row)
                {
                    $row        = get_object_vars($row);
                    $totalcount = $row['totalcount'];
                }
            }

            //  check total data
            if($totalcount > 0)
            {
                $jumlahHalaman          = ceil($totalcount / $jumlahDataPerHalaman);
                $halamanAktif           = intval($valjmlhal);
                $awalData               = (($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman);

                //  mengambil data table
                $sql    = DB::select("call sync_disp_output({$awalData}, {$jumlahDataPerHalaman}, '{$stdate}', '{$endate}', '{$jnsdokbc}', '{$nodokbc}', '{$partno}');");
                $nomor  = $awalData;
                foreach($sql as $rowdata)
                {
                    $no = ++$nomor;
                    $output .= '
                    <tr>
                        <td align="right"><medium class="text-muted">'.$no.'</medium></td>
                        <td>'.$rowdata->jnsdokbc.'</td>
                        <td>'.$rowdata->nodokbc.'</td>
                        <td>'.$rowdata->datedokbc.'</td>
                        <td>'.$rowdata->buktikirim.'</td>
                        <td>'.$rowdata->datekirim.'</td>
                        <td>'.$rowdata->buktiinvoice.'</td>
                        <td>'.$rowdata->dateinvoice.'</td>
                        <td>'.$rowdata->supplier.'</td>
                        <td>'.$rowdata->partno.'</td>
                        <td>'.$rowdata->partname.'</td>
                        <td align="right">'.number_format($rowdata->qty, 0).'</td>
                        <td>'.$rowdata->unit.'</td>
                        <td align="right">'.number_format($rowdata->price, 0).'</td>
                        <td>'.$rowdata->currency.'</td>
                        <td class="text-center">'.$rowdata->input_user.'<br>'.$rowdata->input_date.'</td>
                    </tr>
                    ';
                }
            }
            else
            {
                $jumlahHalaman          = ceil($totalcount / $jumlahDataPerHalaman);
                $halamanAktif           = 0;
                $awalData               = (($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman) + 1;
                $output = '
                <tr>
                <td class="text-center" colspan="16">No Data Found</td>
                </tr>
                ';
            }

            //  mengirim data ke view
            $data = array(
                'table_data'    => $output,
                'totalcount'    => $totalcount,
                'halamanAktif'  => $halamanAktif,
                'jumlahHalaman' => $jumlahHalaman
            );
            echo json_encode($data);
        }
        else{
           //  menghapus session
           $request->session()->forget('session_gitinventory_id');
           $request->session()->forget('session_gitinventory_userid');
           $request->session()->forget('session_gitinventory_username');
           return redirect('/login');
        } */
    }

    //  ***
    //  download
    public function download(Request $request)
    {
        $stdate     = $request->get('stdate') ?? null;
        $endate     = $request->get('endate') ?? null;
        $jnsdokbc   = $request->get('jnsdokbc') ?? null;
        $nodokbc    = $request->get('nodokbc') ?? null;
        $partno     = $request->get('partno') ?? null;
        ($jnsdokbc === 'null') ? null : $jnsdokbc;
        
        $sql    = Http::get($this->domain . $this->url . "json_download_outgoing.php?valstdate={$stdate}&valendate={$endate}&valjnsdok={$jnsdokbc}&valnodok={$nodokbc}&valpartno={$partno}");

        //  mengambil data table
        // $sql    = Http::get($this->domain . $this->url . "json_download_outgoing.php", [
        //     'valstdate' => $stdate,
        //     'valendate' => $endate,
        //     'valjnsdok' => $jnsdokbc,
        //     'valnodok' => $nodokbc,
        //     'valpartno' => $partno
        // ]);
        // return $this->domain . $this->url . "json_download_incoming.php";
        $data = $sql['rows'];
        // return $data;
        //  menampilkan view
        // return view('download.incoming', compact('sql'));
        return view('download.outgoing', compact('data'));
    }
    // public function download(Request $request)
    // {
    //     //  global variable
    //     $stdate     = $request->get('stdate');
    //     $endate     = $request->get('endate');
    //     $jnsdokbc   = $request->get('jnsdokbc');
    //     $nodokbc    = $request->get('nodokbc');
    //     $partno     = $request->get('partno');
    //     $filename   = 'Laporan Pengeluaran';

    //     //  execute database
    //     $datas  = DB::select("call sync_down_output('{$stdate}', '{$endate}', '{$jnsdokbc}', '{$nodokbc}', '{$partno}');");

    //     //  untuk meyimpan data di excel
    //     header("Content-type: application/vnd-ms-excel");
    //     header("Content-Disposition: attachment; filename=". $filename .".xls");
    //     echo '<table>';
    //         echo '<tr>';
    //         echo '<th colspan="6" style="font-size:18pt;" align="left">LAPORAN PENGELUARAN PER DOKUMEN</th>';
    //         echo '</tr>';
    //         echo '<tr>';
    //             echo '<th></th>';
    //         echo '</tr>';
    //     echo '</table>';
    //     echo '<table border="1">';
    //         echo '<tr>';
    //             echo '<th bgcolor="#C0C0C0" rowspan="2">No</th>';
    //             echo '<th bgcolor="#C0C0C0" colspan="3">Dokumen Pabean</th>';
    //             echo '<th bgcolor="#C0C0C0" colspan="2">Bukti Kirim Barang</th>';
    //             echo '<th bgcolor="#C0C0C0" colspan="2">Invoice</th>';
    //             echo '<th bgcolor="#C0C0C0" rowspan="2">Pengirim</th>';
    //             echo '<th bgcolor="#C0C0C0" rowspan="2">Kode Barang</th>';
    //             echo '<th bgcolor="#C0C0C0" rowspan="2">Nama Barang</th>';
    //             echo '<th bgcolor="#C0C0C0" rowspan="2">Jumlah</th>';
    //             echo '<th bgcolor="#C0C0C0" rowspan="2">Satuan</th>';
    //             echo '<th bgcolor="#C0C0C0" rowspan="2">Nilai</th>';
    //             echo '<th bgcolor="#C0C0C0" rowspan="2">Mata Uang</th>';
    //             echo '<th bgcolor="#C0C0C0" rowspan="2">User</th>';
    //         echo '</tr>';
    //         echo '<tr>';
    //             echo '<th bgcolor="#C0C0C0">Jenis</th>';
    //             echo '<th bgcolor="#C0C0C0">No</th>';
    //             echo '<th bgcolor="#C0C0C0">TGL</th>';
    //             echo '<th bgcolor="#C0C0C0">No</th>';
    //             echo '<th bgcolor="#C0C0C0">TGL</th>';
    //             echo '<th bgcolor="#C0C0C0">No</th>';
    //             echo '<th bgcolor="#C0C0C0">TGL</th>';
    //         echo '</tr>';
    //     $no = 1;
    //     for ($i = 0; $i < count($datas); $i++) {
    //         $rowdata = $datas[$i];

    //         echo '<tr>';
    //             echo '<td align="right">'.$no.'</td>';
    //             echo '<td>'.$rowdata->jnsdokbc.'</td>';
    //             echo '<td>'.$rowdata->nodokbc.'</td>';
    //             echo '<td>'.$rowdata->datedokbc.'</td>';
    //             echo '<td>'.$rowdata->buktikirim.'</td>';
    //             echo '<td>'.$rowdata->datekirim.'</td>';
    //             echo '<td>'.$rowdata->buktiinvoice.'</td>';
    //             echo '<td>'.$rowdata->dateinvoice.'</td>';
    //             echo '<td>'.$rowdata->supplier.'</td>';
    //             echo '<td>'.$rowdata->partno.'</td>';
    //             echo '<td>'.$rowdata->partname.'</td>';
    //             echo '<td align="right">'.number_format($rowdata->qty, 0).'</td>';
    //             echo '<td>'.$rowdata->unit.'</td>';
    //             echo '<td align="right">'.number_format($rowdata->price, 0).'</td>';
    //             echo '<td>'.$rowdata->currency.'</td>';
    //             echo '<td>'.$rowdata->input_user.'<br>'.$rowdata->input_date.'</td>';
    //         echo '</tr>';
    //         $no++;
    //     }
    //     echo '</table>';
    // }
}
