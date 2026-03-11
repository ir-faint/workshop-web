<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendOTP;
use Illuminate\Http\Request;
// use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

// use function Symfony\Component\Clock\now;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // var_dump($googleUser);
            // dd($googleUser);
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16))
                ]
            );

            $otp = rand(100000, 999999);
            $user->update([
                'otp' => $otp,
                'otp_expires_at' => now()->plus(minutes: 10)
            ]);

            $user->notify(new SendOTP($otp));
            session(['temp_user_id' => $user->id]);

            return redirect()->route('otp.verify');
        } catch (\Exception $e) {
            // throw new \Exception($e->getMessage());
            return redirect('/login')->withErrors(['error' => 'Google Login failed. Please try again.']);
        }
    }

    public function showOtpForm()
    {
        if (!session()->has('temp_user_id')) {
            return redirect('/login');
        }

        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6'
        ]);

        $userId = session('temp_user_id');
        $user = User::findOrFail($userId);

        if ($request->otp !== $user->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP code! Tolong masukkan kode otp yang benar!']);
        }
        if (now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Expired OTP code! Tolong login kembali untuk mendapatkan kode otp yang baru!']);
        }

        Auth::login($user);
        $user->update([
            'otp' => null,
            'otp_expires_at' => null
        ]);
        session()->forget('temp_user_id');

        return redirect()->route('home');
    }
}
