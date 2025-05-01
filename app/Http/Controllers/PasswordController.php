<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PasswordController extends Controller
{
    public function sendResetPasswordEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $validated['email'];
        $user = User::where('email', $email)->first();

        $resetToken = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $hashedToken = Hash::make($resetToken);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $hashedToken,
            'created_at' => now(),
        ]);

        if ($this->sendPasswordResetEmail($user, $resetToken)) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to send reset link.']);
        }
    }

    private function sendPasswordResetEmail($user, $resetToken)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'evsudcsystem2004@gmail.com';
            $mail->Password = 'rnge tnbq rfxq ijdy';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('evsudcsystem2004@gmail.com', 'Your Application');
            $mail->addAddress($user->email, $user->name);
            $mail->isHTML(true);
            $mail->Subject = "Password Reset Request";

            $resetLink = url('/reset-password?token=' . $resetToken . '&email=' . urlencode($user->email));

            $mail->Body = "
                <div style='max-width: 600px; margin: auto; padding: 20px; background-color: #ffffff; border-radius: 8px; font-family: Arial, sans-serif; box-shadow: 0 2px 8px rgba(0,0,0,0.1);'>
                    <p style='font-size: 18px; font-weight: bold;'>Hello {$user->first_name},</p>
                    <p style='font-size: 16px;'>We received a request to reset your password. Please click the link below to reset your password:</p>
                    <div style='padding: 20px; background-color: #f0f0f0; text-align: center; border-radius: 6px;'>
                        <a href='{$resetLink}' style='font-size: 18px; color: #fff; background-color: #ff8c00; padding: 12px 20px; border-radius: 5px; text-decoration: none;'>Reset Your Password</a>
                    </div>
                    <p style='font-size: 14px; margin-top: 10px; color: #555;'>- This link will expire in 60 minutes.</p>
                    <hr style='margin: 20px 0;'>
                    <p style='font-size: 12px; color: #999;'>This is a system-generated message. Please do not reply to this email.</p>
                </div>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            log_message('error', 'Mailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }

    public function showResetForm(Request $request)
    {
        $token = $request->get('token');
        $email = $request->get('email');
        return view('auth.reset-password', compact('token', 'email'));
    }    

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:password_resets,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $resetRecord = DB::table('password_resets')->where('email', $validated['email'])->first();

        if (!$resetRecord || !Hash::check($validated['token'], $resetRecord->token)) {
            return back()->with('error', 'Invalid or expired token.');
        }

        $user = User::where('email', $validated['email'])->first();
        $user->password = Hash::make($validated['password']);
        $user->save();

        DB::table('password_resets')->where('email', $validated['email'])->delete();

        return redirect()->route('login')->with('success', 'Your password has been reset.');
    }
}
