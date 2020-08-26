<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\DB;
use \Carbon\Carbon;
use App\Message;
use Auth;

class MessagesController extends Controller
{
    public function get($id)
    {
        $userId = Auth::id();
        $message = Message::find($id)->first();

        if ($message->user_id == $userId) {
            return response()->json($message);
        }
    }

    public function index(Request $request)
    {
        $userId = Auth::id();

        $mailbox = $request->query('mailbox', 'inbox');

        if ($mailbox == 'archived') {
            $messages = Message::where(['user_id'  =>  $userId])->whereNotNull('archived_at')->get();
        } else {
            $field = $mailbox === 'sent' ? 'from' : 'to'; 
            $messages = Message::where(['user_id'  =>  $userId, $field  =>  $userId])->whereNull('archived_at')->get();
        }

        return response()->json($messages);
    }

    public function post(Request $request)
    {
        DB::beginTransaction();

        try {
            $this->validate($request, [
                'subject' => 'required|min:1',
                'content' => 'required|min:1',
                'to' => [
                        'required',
                        'exists:users,id'
                    ]
                ]);

            $message = DB::table('messages')->insert(
                [
                    'user_id' => Auth::id(),
                    'from' => Auth::id(),
                    'to' => $request->to,
                    'subject' => $request->subject,
                    'content' => $request->content,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ]
            );

            DB::table('messages')->insert(
                [
                    'user_id' => $request->to,
                    'from' => Auth::id(),
                    'to' => $request->to,
                    'subject' => $request->subject,
                    'content' => $request->content,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ]
            );

            DB::commit();
            return response()->json($message, 201);

        } catch (\Exception $e) {
            DB::rollback();
            abort(400, $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $updateArr = [];
            $messageId = $request->route('id');

            $message = Message::findOrFail($messageId);
            if ($message->user_id !== Auth::id()) abort(403, 'Invalid access.');

            if (isset($request->read)) $message->read_at = Carbon::now();
            if (isset($request->archive)) $message->archived_at = ($request->archive ? Carbon::now() : null);            
            $message->save();

            return response()->json($message);

        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }
}
