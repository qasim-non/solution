<?php

namespace App\Http\Controllers;

use App\Http\Requests\messageRequest;
use App\Http\Requests\projectRequest;
use App\Models\Message;
use App\Models\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{

    public function request(projectRequest $request)
    {
        $validateRequest = $request->validated();

        try {
                Request::createNewRequest($validateRequest);

                return response()->json(['message' => 'The request was created successfully.'], 201);

        } catch (Exception $exception) {
                Log::error('Database transaction failed during createNewRequest: ' . $exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
                'input_data' => $validateRequest // Helps you debug exactly what input broke the DB
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected server error occurred. Please try again later.'
            ], 500);
        }
    }


    public function message(messageRequest $message)
    {
        $validateMessage = $message->validated();

        Message::createNewMessage($validateMessage);

        return response()->json(['message' => 'The message was created successfully.'], 201);
    }
}
