<?php

namespace App\Core\Traits;

use App\Models\Admin;
use App\Notifications\NotifyAdmin;
use App\Notifications\PushNotification;
use Illuminate\Support\Facades\Notification;

trait NotificationMessages {

	protected $notificationMessages = [
		'pending' => [
			'title' => 'New PR received',
			'body' => 'You have received new transaction request by user [user_name]',
		],
		'accepted' => [
			'title' => 'PR Accepted',
			'body' => '[user_type] [user_name] has accepted your transaction "[nogodi_id]" request',
		],
		'expired' => [
			'title' => 'PR Expired',
			'body' => 'Your transaction "[nogodi_id]" has been expired',
		],
		'processed' => [
			'title' => 'PR Processed',
			'body' => 'Your transaction "[nogodi_id]" is in status "in process" now',
		],
		'cancelled' => [
			'title' => 'PR cancelled',
			'body' => 'Your Transaction "[nogodi_id]" has been cancelled by [user_name]',
		],
		'cancellation_requested' => [
			'title' => 'PR cancellation requested',
			'body' => 'You have received transaction cancellation request against transaction "[nogodi_id]"',
		],
		'rejected' => [
			'title' => 'PR Declined',
			'body' => 'PR Request with [nogodi_id] has been declined by [user_name]',
		],
		'delivered' => [
			'title' => 'PR Delivered',
			'body' => 'Your order has been delivered "[nogodi_id]"',
		],
		'completed' => [
			'title' => 'PR Completed',
			'body' => 'Payment has been released to the seller against transaction "[nogodi_id]"',
		],
		'disputed' => [
			'title' => 'Dispute Raised',
			'body' => 'Dispute has been raised against transaction "[nogodi_id]"',
		],
		'under_review' => [
			'title' => 'Dispute Under Review',
			'body' => 'Dispute is under review against transaction "[nogodi_id]"',
		],
		'amount_dispatched' => [
			'title' => 'Amount Dispatched',
			'body' => 'Amount has been dispatched on your bank account',
		],
		'review_request' => [
			'title' => 'PR review request received',
			'body' => 'New PR review request against "[nogodi_id]" received',
		],
		'review_request_accepted' => [
			'title' => 'PR review request accepted',
			'body' => 'PR review request against "[nogodi_id]" has been accepted',
		],
		'review_request_rejected' => [
			'title' => 'PR review request rejected',
			'body' => 'PR review request against "[nogodi_id]" has been rejected',
		],
	];

	protected $adminNotificationMessages = [
		'accepted' => [
			'title' => 'PR Accepted',
			'body' => '[user_type] [user_name] has accepted transaction "[nogodi_id]" request',
		],
		'processed' => [
			'title' => 'PR Processed',
			'body' => 'transaction "[nogodi_id]" is in status “in process” now',
		],
		'cancelled' => [
			'title' => 'PR cancelled',
			'body' => 'PR Request with [nogodi_id] has been cancelled by [user_name]',
		],
		'cancellation_requested' => [
			'title' => 'PR cancellation requested',
			'body' => 'transaction cancellation request raised against transaction "[nogodi_id]" by user [user_name]',
		],
		'declined' => [
			'title' => 'PR Declined',
			'body' => 'PR Request with [nogodi_id] has been declined by [user_name]',
		],
		'delivered' => [
			'title' => 'PR Delivered',
			'body' => 'transaction "[nogodi_id]" is in status “delivered” now',
		],
		'completed' => [
			'title' => 'PR Completed',
			'body' => 'PR Request with [nogodi_id] has been marked as delivered by [user_name]',
		],
		'disputed' => [
			'title' => 'Dispute Raised',
			'body' => 'Dispute has been raised against transaction "[nogodi_id]" by user [user_name]',
		],
		'deactivated' => [
			'title' => 'Account Deactivated',
			'body' => 'User [user_name] has deactivated his / her account',
		],
		'refund' => [
			'title' => 'Amount refunded',
			'body' => 'Payment against transaction "[nogodi_id]" has been refunded',
		],
		'rejected' => [
			'title' => 'PR Declined',
			'body' => 'PR Request with [nogodi_id] has been declined by [user_name]',
		],
		'release' => [
			'title' => 'Amount released',
			'body' => 'Payment against transaction "[nogodi_id]" has been released',
		],
		'dispute_review' => [
			'title' => 'New Internal Request',
			'body' => '[user_name] has requested to review dispute decision',
		],
		// Requests & Support
		'request_assigned' => [
			'title' => 'New Request Assigned',
			'body' => 'new request with [ticket_id] has been assigned you to review',
		],
		'request_rejected' => [
			'title' => 'Request Rejected',
			'body' => 'your request with [ticket_id] has been rejected',
		],
		'request_approved' => [
			'title' => 'Request Approved',
			'body' => 'your request with [ticket_id] has been approved',
		],
	];

	public function sendPushNotification($transaction) {
		try {
			if ($transaction->seller->notify_status == 1) {
				$title = $this->notificationMessages['pending']['title'];
				$body = prepare_text($this->notificationMessages['pending']['body'], [
					'[user_name]' => $transaction->buyer->name,
				]);
				$transaction->seller->notify(new PushNotification(
					$title,
					$body,
					[
						'type'           => 'pr',
						'transaction_id' => $transaction->id,
					]
				));
			}

		} catch (\Exception $e) {
			dd($e->getMessage());
		}

	}

	public function sendAdminNotification($transaction) {

		$admins = Admin::where('status', 1)->get();
		Notification::send($admins, new NotifyAdmin([
			'title'      => 'New Transaction',
			'message'    => 'New transaction ' . $transaction->reference . ' created by user ' . $transaction->buyer->name,
			'created_by' => $transaction->buyer->name,
			'id'         => $transaction->id,
			'route'      => [
				'name'   => 'transactions.show',
				'params' => ['reference' => $transaction->reference],
			],
		]));
	}
}