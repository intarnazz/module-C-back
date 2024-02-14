<?php

namespace App\Http\Controllers\Consultation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consultation;

class ConsultationController extends Controller
{
  public function getAll()
  {
    $consultations = Consultation::all();

    $res = [
      'data' => [
        'problems' => $consultations
      ],
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(200);
  }
  public function get($consultation)
  {
    $consultation = Consultation::all()
      ->where('consultation_id', $consultation)
      ->first();

    $res = [
      'data' => [
        'problems' => $consultation
      ],
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(200);
  }
}
