<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    use ResponseTrait;

    public function update($userId, Request $request)
    {
        $user = User::find($userId);

        $user->name = $request->input("name");
        $user->email = $request->input("email");

        $user->save();

        return User::find($userId);
    }

    public function destroy($userId)
    {
        if(!Auth::user()->can('delete-user')) {
            return $this->sendUnAuthorizedResponse();
        }

        $user = User::find($userId);
        $user->delete();

        if (!User::find($userId) instanceof User) {
            return $this->sendNoContentResponse();
        } else {
            return $this->sendCustomErrorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'User could not be deleted');
        }
    }
}