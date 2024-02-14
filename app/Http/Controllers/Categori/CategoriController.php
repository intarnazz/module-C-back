<?php

namespace App\Http\Controllers\Categori;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Categori;
use App\Models\Question;


class CategoriController extends Controller
{
  public function getAll()
  {
    $categories = Categori::all();
    $res = [
      'data' => [
        'categories' => $categories
      ],
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(200);
  }
  public function add(Request $request)
  {
    $categori = new Categori();
    $categori->categori = $request->title;
    $categori->save();

    $res = [
      'data' => [
        'category' => $categori
      ],
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(201);
  }
  public function change($category, Request $request)
  {
    $categori = Categori::all()
      ->where('categori', $category)
      ->first();
    if (!$categori) {
      $res = [
        'data' => [
          'error' => 'Категория не найдена'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $categori->categori = $request->title;
    $categori->save();

    $res = [
      'data' => [
        'category' => $categori
      ],
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(200);
  }
  public function delete($category, Request $request)
  {
    $categori = Categori::all()
      ->where('categori', $category)
      ->first();
    if (!$categori) {
      $res = [
        'data' => [
          'error' => 'Категория не найдена'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $question = Question::all()
      ->where('categori_id', $categori->categori_id)
      ->first();
    if ($question) {
      $res = [
        'data' => [
          'error' => 'Категория содержит вопросы'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(400);
    }
    $categori->delete();

    $res = [
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(200);
  }
  public function getProblems($category, Request $request)
  {
    $categori = Categori::all()
      ->where('categori', $category)
      ->first();
    if (!$categori) {
      $res = [
        'data' => [
          'error' => 'Категория не найдена'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $questions = Question::all()
      ->where('categori_id', $categori->categori_id);

    $res = [
      'data' => [
        'problems' => $questions
      ],
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(200);
  }
  public function addProblems($category, Request $request)
  {
    $categori = Categori::all()
      ->where('categori', $category)
      ->first();
    if (!$categori) {
      $res = [
        'data' => [
          'error' => 'Категория не найдена'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $question = new Question();
    $question->categori_id = $categori->categori_id;
    $question->question = $request->title;
    $question->save();

    $res = [
      'data' => [
        'problems' => $question
      ],
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(200);
  }
  public function changeProblems($category, $problem, Request $request)
  {
    $categori = Categori::all()
      ->where('categori', $category)
      ->first();
    if (!$categori) {
      $res = [
        'data' => [
          'error' => 'Категория не найдена'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $question = Question::all()
      ->where('question', $problem)
      ->first();
    if (!$question) {
      $res = [
        'data' => [
          'error' => 'Вопрос не найден'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $question->question = $request->title;
    $question->save();

    $res = [
      'data' => [
        'problem' => $question
      ],
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(201);
  }
  public function deleteProblems($category, $problem, Request $request)
  {
    $categori = Categori::all()
      ->where('categori', $category)
      ->first();
    if (!$categori) {
      $res = [
        'data' => [
          'error' => 'Категория не найдена'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $question = Question::all()
      ->where('question', $problem)
      ->first();
    if (!$question) {
      $res = [
        'data' => [
          'error' => 'Вопрос не найден'
        ],
        'status' => 'error',
      ];
      return response()->json($res)->setStatusCode(404);
    }
    $question->delete();

    $res = [
      'status' => 'ok',
    ];
    return response()->json($res)->setStatusCode(200);
  }
}
