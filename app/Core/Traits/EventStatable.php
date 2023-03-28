<?php
namespace App\Core\Traits;

use App\Models\Event;
use App\Models\Country;
use App\Models\EventLog;
use Illuminate\Support\Facades\DB;

trait EventStatable{
    
    protected function ageLogs(Event $event,$type = 'saved'){
        $logs = \DB::select(
            'SELECT IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) <= 13),0) as below_13,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?) AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 13 AND 17),0)  as 13_17,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 18 AND 24 ),0)  as 18_24,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 25 AND 34  ),0) as 25_34,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 35 AND 44 ),0) as 35_44,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 55 AND 64 ),0) as 55_64,
            IFNULL((SELECT COUNT(*) FROM users where id IN (SELECT user_id FROM event_logs WHERE event_id = ? AND type = ?)  AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) >= 65),0) as 65_plus'
        ,[
            $event->id,
            $type,
            $event->id,
            $type,
            $event->id,
            $type,
            $event->id,
            $type,
            $event->id,
            $type,
            $event->id,
            $type,
            $event->id,
            $type
        ])[0];
        $i = 0;
        $filtered_logs = [];
        collect($logs)->each(function($value,$key) use(&$i,&$filtered_logs){
            $color = 'yellow';
            if($i % 2 === 0 ){
                $color = 'black';
            }
            $title = str_replace(['_plus','below_','_'],['+','Below ','-'],$key);                
            $filtered_logs[] =  [$title,$value,$color];
            $i++;
        });

        return $filtered_logs;
    }

    protected function countryLogs(Event $event,$type = 'saved'){
        return Country::addSelect([
            'id',
            'name',
            'users_count' => EventLog::selectRaw('COUNT(*)')
                    ->whereIn('user_id',function($q){
                        $q->select('id')
                        ->from('users')
                        ->whereColumn('users.country_id','countries.id');
                    })->where('event_logs.type',$type)
                    ->where('event_id',$event->id),
        ])->whereIn('id',function($q) use($type){
            $q->select('country_id')
            ->from('users')
            ->whereIn('users.id',function($q) use($type){
                $q->select('user_id')
                ->from('event_logs')
                ->where('event_id',request('event_id'))
                ->where('type',$type);
            });
        })->get()->map(function($country,$index){
            $color = 'yellow';
            if($index % 2 === 0 ){
                $color = 'black';
            }
            return [$country->name,$country->users_count,$color];
        });
        
    }
}

?>