<?php
namespace App\Core\Traits;

use App\Mail\SendMail;
use App\Models\User;
use App\Notifications\Auth\VerificationCode;
use App\Notifications\SendSms;

trait Verifiable {

	protected $verificationModel = null;
	
	public function send_sms(&$to, $message) {
		if(gettype($to) != 'string'){

			try {
				$user->notify(new SendSms($message));
			} catch (\Exception $e) {
				if (!request()->filled('debug') && !request('debug')) {
					throw new \Exception($e->getMessage());
				}
			}
		}
	}
	public function send_email(&$user, $subject = 'NOGODI | Notification', $message) {
		try {
			\Mail::to($user->email)->send(new SendMail($user, $subject, $message));
		} catch (\Exception $e) {
			if (!request()->filled('debug') && !request('debug')) {
				throw new \Exception($e->getMessage());
			}
		}
	}

	private function sendFallBack(&$user) {
		$user->phone_otp = '1234';
		$user->email_otp = '1234';
	}
}
?>