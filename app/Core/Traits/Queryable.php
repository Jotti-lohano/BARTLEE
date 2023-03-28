<?php
namespace App\Core\Traits;

use App\Models\Transaction;
use App\Models\TransactionPayment;
use App\Models\TransactionReference;

trait Queryable {
    
    public function buildHoldAmountQuery($userType = 'seller',$amountColumn = 'total_amount',$userId = null){
        return TransactionReference::
        selectRaw("IFNULL((
            CASE WHEN 
                (SUM(amount) = {$amountColumn}) 
            THEN 
                {$amountColumn} 
            ELSE
            ABS(SUM(amount) - {$amountColumn})
            END),0)")
        ->whereIn('transaction_id',function($q) use($userType, $userId){
            $q->select('id')
            ->from('transactions')
            ->when($userId,function($q) use ($userId,$userType) {
                $q->where("{$userType}_id",$userId);
            })
            ->when(!$userId,function($q) use ($userId,$userType) {
                $q->whereColumn("{$userType}_id",'users.id');
            })
            ->whereIn('status',["accepted","processed","delivered","disputed"])
            ->whereIn('transaction_id',function($q) use($userType,$userId){
                $q->select('transaction_id')
                ->from('transaction_payments')
                ->when($userId,function($q) use ($userType,$userId) {
                    $q->where("{$userType}_id",$userId);
                })
                ->when(!$userId,function($q) use ($userType,$userId) {
                    $q->whereColumn("{$userType}_id",'users.id');
                })
                ->whereNull('received_by')
                ->where('status','hold');
            });
        });
    }

    public function buildMediatorAccountQuery($amountColumn = 'total_amount',$userId = null){
        return TransactionReference::
                    selectRaw("(
                        CASE WHEN 
                            (SUM(amount) = {$amountColumn}) 
                        THEN 
                            IFNULL({$amountColumn},0) 
                        ELSE
                        IFNULL(ABS(SUM(amount) - {$amountColumn}),0)
                        END)")
                    ->whereIn('transaction_id',function($q) use($userId){
                        $q->select('id')
                        ->from('transactions')
                        ->when(!$userId,function($q){
                            
                            $q->whereColumn('seller_id','users.id');
                        })
                        ->when($userId,function($q) use($userId){
                            
                            $q->where('seller_id',$userId);
                        })
                        ->where('status','completed')
                        ->whereIn('transaction_id',function($q) use($userId){
                            $q->select('transaction_id')
                            ->from('transaction_payments')
                            ->when(!$userId,function($q){
                                $q->whereColumn('receiver_id','users.id');
                            })
                            ->when($userId,function($q) use ($userId) {
                                $q->where('receiver_id',$userId);
                            })
                            ->where('received_by','seller')
                            ->where('status','hold');
                        })
                        ->groupBy('transaction_id');
                    });
    }

    public function buildTotalAmountQuery($userType = 'seller',$userId = null,$statuses = ['completed']){
        return Transaction::selectRaw('SUM(amount)')
        ->when(!$userId,function($q) use($userType){                                                                                    
            $q->whereColumn("{$userType}_id",'users.id');
        })
        ->when($userId,function($q) use ($userId,$userType,$statuses) {
            $q->where("{$userType}_id",$userId);
        })
                ->whereIn('status',$statuses)
                ->whereIn('id',function($q) use($userId,$userType){
                    $q->select('transaction_id')
                        ->from('transaction_payments')
                        ->when(!$userId,function($q) use($userType){                                                                                    
                            $q->whereColumn("{$userType}_id",'users.id');
                        })
                        ->when($userId,function($q) use($userId, $userType){                            
                            $q->where("{$userType}_id",$userId);
                        })
                        ->where('status','hold');
                });
                    
    }
}

?>