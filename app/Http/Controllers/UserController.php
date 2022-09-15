<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
	/**
	 * @OA\Get(
	 * path="/api/users",
	 * summary="Список пользователей",
	 * description="Получение списка всех пользователей",
	 * tags={"Пользователи"},
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
		
		return response()->json(User::all());
	}
}
