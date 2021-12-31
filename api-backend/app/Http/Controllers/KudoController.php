<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kudo;
use App\Models\KudoCard;

class KudoController extends Controller
{

    public function list(Request $request)
    {

      $kudos = Kudo::all();

      return response()->json([
        'success' => true,
        'data' => $kudos
      ], 201);

    }

    public function getKudoById(Request $request, $id)
    {
      $kudo = Kudo::findOrFail($id);

      return response()->json([
        'success' => true,
        'data' => $kudo
      ], 201);
    }

    public function getKudoCardById(Request $request, $id)
    {
      $kudo = Kudo::findOrFail($id);
      $cards = $kudo->cards()->get();

      return response()->json([
        'success' => true,
        'data' => [
          'title' => $kudo->title,
          'cards' => $cards
        ]
      ], 201);
    }

    public function save(Request $request)
    {

      $user = new Kudo([
          'user_id' => $request["user"],
          'title' => $request["title"]
      ]);

      $user->save();

      return response()->json([
        'success' => true,
        'message' => 'Kudo was created succesfully'
      ], 201);

    }

    public function saveCard(Request $request)
    {

      $card = new KudoCard([
          'kudo_id' => $request["kudoId"],
          'subject' => $request["subject"],
          'comment' => $request["comment"]
      ]);

      $card->save();

      return response()->json([
        'success' => true,
        'message' => 'Card was created succesfully'
      ], 201);

    }
}
