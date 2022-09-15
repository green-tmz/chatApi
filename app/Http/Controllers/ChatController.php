<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chats;

class ChatController extends Controller
{
	/**
	 * @OA\Get(
	 * path="/api/chats",
	 * summary="Список чатов",
	 * description="Получение списка всех чатов",
	 * tags={"Чаты"},
	 * @OA\Response(
	 *    response=200,
	 *    description="success",
	 * )
	 * )
	 */
    public function index(Request $request)
    {
		if ($request->method() != 'GET') {
			return response()->json(['error' => 'Метод не поддерживается']);
		}
		
		return response()->json(Chats::all());
	}
}
