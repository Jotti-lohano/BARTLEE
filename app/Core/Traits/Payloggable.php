<?php

namespace App\Core\Traits;

use App\Models\Transaction;

trait Payloggable {

	public function transactions() {
		return $this->morphMany(Transaction::class, 'transitionable');
	}

	public function savePayLog($amount, $message, $transactionId) {
		$log = new Transaction([
			'description'    => $message,
			'amount'         => $amount,
			'transactor'     => auth()->id(),
			'transaction_id' => $transactionId,
		]);
		return $this->transactions()->save($log);
	}

	public function transaction() {
		return $this->morphOne(Transaction::class, 'transitionable');
	}

}
