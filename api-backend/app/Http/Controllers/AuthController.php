<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function signup(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $validator = Validator::make($data, [
          'name' => 'required|string',
          'email' => 'required|string|email|unique:users',
          'password' => 'required|string'
        ]);

        if ($validator->fails()) {
           return response()->json([
              'success' => false,
              'message' => $validator->errors()
           ]);
       }

       $validated = $validator->validated();

        $user = new User([
            'name' => $validated["name"],
            'email' => $validated["email"],
            'password' => bcrypt($validated["password"])
        ]);

        $user->save();

        return response()->json([
          'success' => true,
          'message' => 'User was created succesfully'
        ], 201);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ]);

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return response()->json([
            'success' => true,
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }


    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
