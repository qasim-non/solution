<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
use App\Http\Requests\projectRequestsRequest;
use App\Models\Admin;
use App\Models\Message;
use App\Models\Request;
use App\Models\RequestSocialMedia;
use App\Models\SocialMediaPlatform;
use App\Models\SystemType;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function dashboardInfo()
    {
        $info = Request::dashboardInfo();
        return response()->json(['message' => 'The data is succffly gathred', 'data' => $info], 200);
    }


    public function login(loginRequest $login)
    {
        $loginInfoValidated = $login->validated();

        $admin = Admin::getAdmin($loginInfoValidated);

        if (!$admin)
            {
                return response()->json([
                'status' => 'error',
                'message' => "The username {$loginInfoValidated['username']} entered are wrong",
            ], 401);
            }

        if (!Hash::check($loginInfoValidated['password'], $admin['password']))
            {
                return response()->json([
                'status' => 'error',
                'message' => "The password {$loginInfoValidated['password']} entered are wrong",
            ], 401);
            }

        $token = $admin->createToken('loginToken')->plainTextToken;

        return response()->json(['message' => 'the admin login succffly', 'token' => $token], 200);

    }


    public function returnAllRequests(projectRequestsRequest $request)
    {
        $requestValidated = $request->validated();

        $requests = Request::getAllRequests()->when(isset($requestValidated['search']), function ($query) use ($requestValidated)
        {
            return Request::searchByName($query, $requestValidated['search']);

        })->when(isset($requestValidated['system_type']), function ($query) use ($requestValidated)
        {
            return Request::searchBySystemTypes($query, $requestValidated['system_type']);

        })->when(isset($requestValidated['status']), function ($query) use ($requestValidated)
        {
            return Request::searchByStatus($query, $requestValidated['status']);

        })->when(isset($requestValidated['start_date']), function ($query) use ($requestValidated)
        {
            return Request::searchByDate($query, $requestValidated['start_date'], $requestValidated['end_date']);
        });


        return response()->json(['message' => 'All requests are gatherd succffly.', 'data' => $requests->get()], 200);

    }


    public function requestComplete(Request $request)
    {
        if ($request->status == 'completed')
            {
        return response()->json(['message' => 'the status is already comleted.'], 400);
            }
        Request::requestToComplete($request['id']);

        return response()->json(['message' => 'status changed to completed.'], 200);
    }


    public function requestRevert(Request $request)
    {
        if ($request->status == 'pending')
            {
        return response()->json(['message' => 'the status is already pending.'], 400);
            }

        Request::requestToPending($request['id']);

        return response()->json(['message' => 'status changed to pending.'], 200);
    }


    public function systemTypes()
    {
        $types = SystemType::getTypes();

        return response()->json(['message' => 'system types gatherd succffly', 'types' => $types], 200);
    }

    public function returnAllMessages()
    {
        $messages = Message::getAllMessages();

        return response()->json(['messages' => $messages], 200);
    }

    public function returnSocialMediaAccount(Request $request)
    {
        $accounts = RequestSocialMedia::returnSocialMediaAccounts($request->id);

        return response()->json(['messages' => $accounts], 200);
    }

}
