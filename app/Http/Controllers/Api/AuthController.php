<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentioals are incorrtect.']
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentioals are incorrtect.']
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }


    public function CodeVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users'
        ]);

        //Generate a verification code 
        $verificationCode = rand(100000, 999999);


        //Check for existing email
        $existingCode = VerificationCode::where('email', $request->email)->first();

        if ($existingCode) {
            //If the email exist, update the existing record
            $existingCode->update([
                'code' => $verificationCode
            ]);
        } else {
            //If the email dosnt exist
            VerificationCode::create([
                'email' => $request->email,
                'code' => $verificationCode
            ]);
        }


        try {
            // Send the verification code to the user's email
            Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));

            return response()->json(
                [
                    'message' => 'پیام با موفقیت ارسال شد',
                    'mailedto' => $request->email
                ],
                200
            );
        } catch (\Exception $e) {
            // Handle any errors that occur during email sending
            return response()->json(['error' => 'Failed to send: ' . $e->getMessage()], 500);
        }
    }


    public function signup(Request $request)
    {
        //validate password and email
        $request->validate([
            'email' => 'required|email|unique:users',
            'verification_code' => 'required|numeric',
            'password' => 'required|min:6'
        ]);

        //Check if verification code is correct
        $isCodeCorrect = $this->checkVerificationCode($request->email, $request->verification_code);


        if (!$isCodeCorrect) {
            return response()->json([
                "error" => "کد تایید را اشتباه وارد کردید"
            ], 422);
        } else {

            //get User status
            $existingUser = User::where('email', $request->email)->first();
            if (!$existingUser) {
                //Register The user
                $user = User::create([
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);

                if ($user) {
                    return response()->json(['message' => 'ثبت نام با موفقیت انجام شد'], 201);
                } else {
                    return response()->json(['error' => 'ثبت نام انجام نشد'], 500);
                }
            }
        }
    }


    private function checkVerificationCode($email, $code)
    {
        $verificationCode = VerificationCode::where('email', $email)
            ->where('code', $code)
            ->first();

        return $verificationCode !== null;
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
