<?php

namespace App\Http\Controllers\Consultation;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Region;
use App\Models\RegionOrganization;
use App\Models\Organization;
use App\Models\ConsultantOrganization;
use App\Models\Consultant;
use App\Models\Categori;
use App\Models\Question;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ConsultationController extends Controller
{
  public function getAll()
  {
    $consultations = Consultation::all();

    $res = [
      'data' => [
        'consultation' => $consultations
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
    if (!$consultation) {
      $res = [
        'data' => [
          'error' => 'консультация не найдена'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $res = [
      'data' => [
        'consultation' => $consultation
      ],
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(200);
  }
  public function add(Request $request)
  {
    $consultation = new Consultation();
    $region = Region::all()
      ->where('region_id', $request->region_id)
      ->first();
    $res = [
      'data' => [
        'error' => []
      ],
      'status' => 'error',
    ];
    if (!$region) {
      $res['data']['error'][] = 'Регион не найден';
    }
    $organization = Organization::all()
      ->where('organization_id', $request->organization_id)
      ->first();
    if (!$organization) {
      $res['data']['error'][] = 'Организация не найдена';
    }
    $region_organization = RegionOrganization::all()
      ->where('organization_id', $request->organization_id)
      ->where('region_id', $request->region_id)
      ->first();
    if (!$region_organization) {
      $res['data']['error'][] = 'Организация не найдена в этом регионе';
    }
    $consultant = Consultant::all()
      ->where('consultant_id', $request->consultant_id)
      ->first();
    if (!$consultant) {
      $res['data']['error'][] = 'консультант не найден';
    }
    $consultant_organization = ConsultantOrganization::all()
      ->where('organization_id', $request->organization_id)
      ->where('consultant_id', $request->consultant_id)
      ->first();
    if (!$consultant_organization) {
      $res['data']['error'][] = 'Сонсультант не найден в этой организации';
    }
    $categori = Categori::all()
      ->where('categori_id', $request->categori_id)
      ->first();
    if (!$categori) {
      $res['data']['error'][] = 'Категория не найдена';
    }
    $question = Question::all()
      ->where('question_id', $request->question_id)
      ->first();
    if (!$question) {
      $res['data']['error'][] = 'Вопрос не найден';
    }
    $validator = Validator::make($request->all(), [
      'firstname' => 'required|string',
    ]);
    if ($validator->fails()) {
      $res['data']['error'][] = 'Неверное имя';
    }
    $validator = Validator::make($request->all(), [
      'lastname' => 'required|string',
    ]);
    if ($validator->fails()) {
      $res['data']['error'][] = 'Неверноя фамилия';
    }
    $validator = Validator::make($request->all(), [
      'email' => 'required|email',
    ]);
    if ($validator->fails()) {
      $res['data']['error'][] = 'Неверный email';
    }
    $validator = Validator::make($request->all(), [
      'tel' => ['required', 'regex:/^\+7[0-9]{10}$/'],
    ]);
    if ($validator->fails()) {
      $res['data']['error'][] = 'Неверный телефон';
    }
    $validator = Validator::make($request->all(), [
      'kid' => 'required|string',
    ]);
    if ($validator->fails()) {
      $res['data']['error'][] = 'Неверное имя ребёнка';
    }
    $validator = Validator::make($request->all(), [
      'age' => 'required|integer',
    ]);
    if ($validator->fails()) {
      $res['data']['error'][] = 'Неверный возраст ребёнка';
    } else if ($request->age <= 1 || $request->age >= 18) {
      $res['data']['error'][] = 'Неверный возраст ребёнка';
    }

    if (!$res['data']['error']) {
      $consultation->firstname = $request->firstname;
      $consultation->lastname = $request->lastname;
      $consultation->email = $request->email;
      $consultation->tel = $request->tel;
      $consultation->kid = $request->kid;
      $consultation->age = $request->age;
      $consultation->region_id = $request->region_id;
      $consultation->organization_id = $request->organization_id;
      $consultation->consultant_id = $request->consultant_id;
      $consultation->categori_id = $request->categori_id;
      $consultation->question_id = $request->question_id;
      $consultation->dateFrom = $request->date;
      $consultation->code = Str::random(6);
      $consultation->save();

      $consultation = Consultation::all()
        ->where('consultation_id', $consultation->consultation_id)
        ->first();

      $res = [
        'data' => [
          'consultation' => $consultation,
          'organization' => $organization,
          'region' => $region,
          'consultant' => $consultant,
          'categori' => $categori,
          'question' => $question,
          'code' => $consultation->code,
        ],
        'status' => 'ok',
      ];
      return response()->json($res)->setStatusCode(201);
    }
    return response()->json($res)->setStatusCode(400);
  }
  public function rating($consultation, Request $request)
  {
    $consultation = Consultation::all()
      ->where('consultation_id', $consultation)
      ->first();
    if (!$consultation) {
      $res = [
        'data' => [
          'error' => 'консультация не найдена'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    if ($request->status) {
      $consultation->status = $request->status;
      if ($request->rejection) {
        $consultation->rejection = $request->rejection;
      }
      if ($request->consDate) {
        $consultation->dateFrom = $request->consDate;
      }
      if ($request->advice) {
        $consultation->advice = $request->advice;
      }
      if ($request->result) {
        $consultation->result = $request->result;
      }
      $consultation->save();
      $res = [
        'data' => [
          'consultation' => $consultation
        ],
        'status' => 'ok',
      ];
      return response()->json($res)->setStatusCode(200);
    }




    $validator = Validator::make($request->all(), [
      'rating' => 'required|integer',
    ]);
    if ($validator->fails()) {
      $res = [
        'data' => [
          'error' => 'Неверная оценка'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(401);
    }
    if ($request->rating <= 1 || $request->rating >= 5) {
      $res = [
        'data' => [
          'error' => 'Неверная оценка'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(401);
      if (!($consultation->code == $request->code)) {
        $res = [
          'data' => [
            'error' => 'Неверный код'
          ],
          'status' => 'error',
        ];
        return response()->json($res)->setStatusCode(401);
      }
    }
    $res = [
      'data' => [
        'consultation' => $consultation
      ],
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(200);
  }
}
