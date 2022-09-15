<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Messages;
use App\Models\Chats;


class MessageController extends Controller
{
    /**
	 * @OA\Get(
	 * path="/api/message/all",
	 * summary="Вывод сообщений",
	 * description="Вывод всех сообщений чата",
	 * tags={"Сообщения"},
	 * @OA\Parameter(
	 *    description="Количество сообщений",
	 *    in="query",
	 *    name="count",
	 *    required=true,
	 *    @OA\Schema(
	 *       type="integer"
	 *    )
	 * ),
	 * @OA\Parameter(
	 *    description="Id чата",
	 *    in="query",
	 *    name="chatId",
	 *    required=true,
	 *    @OA\Schema(
	 *       type="integer"
	 *    )
	 * ),
	 * @OA\Response(
	 *    response=200,
	 *    description="success"
	 * )
	 * )
	 */
    public function index(Request $request)
    {
		if ($request->method() != 'GET') {
			return response()->json(['error' => 'Метод не поддерживается']);
		}
		
        $chat = Chats::find($request->input('chatId'));
        
        if (!$chat) {
			return response()->json(['error' => 'Чат не найден']);
		}
		
		$messages = Messages::where('chat_id', '=', $request->input('chatId'))
			->simplePaginate($request->input('count'));
			
		return response()->json($messages);
    }

    /**
	 * @OA\Post(
	 * path="/api/message/add",
	 * summary="Добавление сообщения",
	 * description="Добавление сообщения в чат",
	 * tags={"Сообщения"},
	 * @OA\Parameter(
	 *    description="Id пользователя",
	 *    in="query",
	 *    name="userId",
	 *    required=true,
	 *    @OA\Schema(
	 *       type="integer"
	 *    )
	 * ),
	 * @OA\Parameter(
	 *    description="Id чата",
	 *    in="query",
	 *    name="chatId",
	 *    required=true,
	 *    @OA\Schema(
	 *       type="integer"
	 *    )
	 * ),
	 * @OA\Parameter(
	 *    description="Сообщение",
	 *    in="query",
	 *    name="message",
	 *    required=true,
	 *    @OA\Schema(
	 *       type="string"
	 *    )
	 * ),
	 * @OA\Response(
	 *    response=200,
	 *    description="success"
	 * )
	 * )
	 */
    public function create(Request $request)
    {
		if ($request->method() != 'POST') {
			return response()->json(['error' => 'Метод не поддерживается']);
		}
		
		$input = Validator::make($request->input(), [
            'message' => 'max:100',
        ]);
		
		if ($input->fails()) {
			return response()->json(['error' => 'Ошибка валидации']);
		}
		
		$messages = new Messages();
		$messages->user_id = $request->input('userId');
		$messages->chat_id = $request->input('chatId');
		$messages->message = $request->input('message');
		
		if ($messages->save()) {
			return response()->json(['success' => true]);
		}
		
        return response()->json(['success' => false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
	 * @OA\Delete(
	 * path="/api/message/delete",
	 * summary="Удаление сообщения",
	 * description="Удаление сообщения из чата",
	 * tags={"Сообщения"},
	 * @OA\Parameter(
	 *    description="Id сообщения",
	 *    in="query",
	 *    name="messageId",
	 *    required=true,
	 *    @OA\Schema(
	 *       type="integer"
	 *    )
	 * ),
	 * @OA\Response(
	 *    response=200,
	 *    description="success"
	 * )
	 * )
	 */
    public function destroy(Request $request)
    {
		if ($request->method() != 'DELETE') {
			return response()->json(['error' => 'Метод не поддерживается']);
		}
		
        $message = Messages::find($request->input('messageId'));
        
        if (!$message) {
			return response()->json(['error' => 'Сообщение не найдено']);
		}
		
		if ($message->delete()) {
			return response()->json(['success' => true]);
		}
		
        return response()->json(['success' => false]);
    }
}
