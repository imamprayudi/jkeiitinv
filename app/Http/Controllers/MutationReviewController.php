<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ApiConfigurationTrait;

class MutationReviewController extends Controller
{ 
  use ApiConfigurationTrait;
  
  public function __construct()
  {
    $this->initializeApiConfiguration();
  }
  
  public function index()
  {
    $kategori_data = [
      'title' => 'Gudang Material Review',
      'kategori' => 'bahan_baku',
      'gudang' => 'Gudang Material'
    ];
    return view('review.bahan_baku_gm', 
    compact('kategori_data'));
  }

  public function loaddata(Request $request)
{
  //dump(class_uses($this));
  //dump(method_exists($this, 'makeApiRequest'));
  //die();
  \Log::info('=== MASUK KE LOADDATA REVIEW ===');

    $params = [
        'periode'  => $request->periode ?? '2026-06',
        'gudang'   => $request->gudang ?? 'Gudang Material',
        'kategori' => $request->kategori ?? 'Bahan baku',
        'page'     => 0,
        'limit'    => 100, // 🔥 INI KUNCI REVIEW KITA
    ];

    $data = $this->makeApiRequest('json_mutation.php', $params);

    return response()->json([
        'status' => 'OK',
        'count'  => count($data['rows'] ?? []),
        'data'   => $data['rows'] ?? [],
    ]);
}

} 
