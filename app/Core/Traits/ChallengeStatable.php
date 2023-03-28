<?php
namespace App\Core\Traits;

use App\Models\Challenge;

trait ChallengeStatable{

    protected function challenge_gender_stats(Challenge $challenge,$operand = '<'){
        $gender_logs = \DB::select(
            'SELECT IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND user_challenges.user_id = users.id
                        HAVING 
                        COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ? AND 
                    gender = "male"
                    ),
            0) as male,
            IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND user_challenges.user_id = users.id
                        HAVING 
                        COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ? AND 
                    gender = "female"
                    ),
            0) as female',[
                $challenge->id,
                $challenge->id,
                $challenge->total_visits_required,
                $challenge->total_visits_required,
                $challenge->id,
                $challenge->id,
                $challenge->total_visits_required,
                $challenge->total_visits_required,
            ]);

            return $gender_logs[0];
    }

    protected function challenge_age_stats(Challenge $challenge,$operand = '<'){
        $logs = \DB::select(
            'SELECT IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND user_challenges.user_id = users.id
                        HAVING 
                        COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    AND 
                    (
                        SELECT 
                            DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) <= 13
                    ),
            0) as below_13,
            IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND user_challenges.user_id = users.id
                        HAVING 
                        COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 13 AND 17),
            0) as 13_17,
            IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND user_challenges.user_id = users.id
                        HAVING 
                        COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 18 AND 24),
            0) as 18_24,
            IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND user_challenges.user_id = users.id
                        HAVING 
                        COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 25 AND 34),
            0) as 25_34,
            IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND user_challenges.user_id = users.id
                        HAVING 
                        COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 35 AND 44),
            0) as 35_44,
            IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND user_challenges.user_id = users.id
                        HAVING 
                        COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) BETWEEN 55 AND 64),
            0) as 55_64,
            IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND user_challenges.user_id = users.id
                        HAVING 
                        COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    AND (SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( dob,CURDATE() ) ), "%Y")+0 AS age) >= 65),
            0) as 65_plus'
        ,[
            $challenge->id,
            $challenge->id,
            $challenge->total_visits_required,
            $challenge->total_visits_required,
            $challenge->id,
            $challenge->id,
            $challenge->total_visits_required,
            $challenge->total_visits_required,
            $challenge->id,
            $challenge->id,
            $challenge->total_visits_required,
            $challenge->total_visits_required,
            $challenge->id,
            $challenge->id,
            $challenge->total_visits_required,
            $challenge->total_visits_required,
            $challenge->id,
            $challenge->id,
            $challenge->total_visits_required,
            $challenge->total_visits_required,
            $challenge->id,
            $challenge->id,
            $challenge->total_visits_required,
            $challenge->total_visits_required,
            $challenge->id,
            $challenge->id,
            $challenge->total_visits_required,
            $challenge->total_visits_required,
        ])[0];

        $filtered_logs = [];
        $i = 0;
        collect($logs)->each(function($value,$key) use(&$i,&$filtered_logs){
            $color = 'yellow';
            if($i % 2 === 0 ){
                $color = 'black';
            }
            
            $title = str_replace(['_plus','below_','_'],['+','Below ','-'],$key);

            $filtered_logs[] =  [$title,$value,$color];
        });
        return $filtered_logs;
    }

    protected function challenge_week_stats(Challenge $challenge,$operand = '='){
        $logs = \DB::select(
            'SELECT IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND 
                        created_at BETWEEN ? AND ?
                        ORDER BY id desc
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                            challenge_id = ?
                            AND user_challenges.user_id = users.id
                        HAVING 
                            COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    ),
            0) as mon,
            IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND 
                        created_at BETWEEN ? AND ?
                        ORDER BY id desc
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                            challenge_id = ?
                            AND user_challenges.user_id = users.id
                        HAVING 
                            COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    ),
            0) as tue,
            IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND 
                        created_at BETWEEN ? AND ?
                        ORDER BY id desc
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                            challenge_id = ?
                            AND user_challenges.user_id = users.id
                        HAVING 
                            COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    ),
            0) as wed,
            IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND 
                        created_at BETWEEN ? AND ?
                        ORDER BY id desc
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                            challenge_id = ?
                            AND user_challenges.user_id = users.id
                        HAVING 
                            COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    ),
            0) as thu,
            IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND 
                        created_at BETWEEN ? AND ?
                        ORDER BY id desc
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                            challenge_id = ?
                            AND user_challenges.user_id = users.id
                        HAVING 
                            COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    ),
            0) as fri,
            IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND 
                        created_at BETWEEN ? AND ?
                        ORDER BY id desc
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                            challenge_id = ?
                            AND user_challenges.user_id = users.id
                        HAVING 
                            COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    ),
            0) as sat,
            IFNULL(
                (
                SELECT 
                    COUNT(*) 
                FROM 
                    users 
                where id IN 
                    (
                        SELECT 
                           user_id 
                        FROM 
                            user_challenges 
                        WHERE 
                        challenge_id = ?
                        AND 
                        created_at BETWEEN ? AND ?
                        ORDER BY id desc
                    )
                    AND (
                        SELECT 
                           COUNT(user_id) 
                        FROM 
                            user_challenges 
                        WHERE 
                            challenge_id = ?
                            AND user_challenges.user_id = users.id
                        HAVING 
                            COUNT(user_id) '.$operand.' ?
                    )  '.$operand.' ?
                    ),
            0) as sun',[
                $challenge->id,
                now()->startOfWeek()->startOfDay(),
                now()->startOfWeek()->endOfDay(),
                $challenge->id,
                $challenge->total_visits_required,
                $challenge->total_visits_required,
                $challenge->id,
                now()->startOfWeek()->addDay(1)->startOfDay(),
                now()->startOfWeek()->addDay(1)->endOfDay(),
                $challenge->id,
                $challenge->total_visits_required,
                $challenge->total_visits_required,
                $challenge->id,
                now()->startOfWeek()->addDay(2)->startOfDay(),
                now()->startOfWeek()->addDay(2)->endOfDay(),
                $challenge->id,
                $challenge->total_visits_required,
                $challenge->total_visits_required,
                $challenge->id,
                now()->startOfWeek()->addDay(3)->startOfDay(),
                now()->startOfWeek()->addDay(3)->endOfDay(),
                $challenge->id,
                $challenge->total_visits_required,
                $challenge->total_visits_required,
                $challenge->id,
                now()->startOfWeek()->addDay(4)->startOfDay(),
                now()->startOfWeek()->addDay(4)->endOfDay(),
                $challenge->id,
                $challenge->total_visits_required,
                $challenge->total_visits_required,
                $challenge->id,
                now()->startOfWeek()->addDay(5)->startOfDay(),
                now()->startOfWeek()->addDay(5)->endOfDay(),
                $challenge->id,
                $challenge->total_visits_required,
                $challenge->total_visits_required,
                $challenge->id,
                now()->startOfWeek()->addDay(6)->startOfDay(),
                now()->startOfWeek()->addDay(6)->endOfDay(),
                $challenge->id,
                $challenge->total_visits_required,
                $challenge->total_visits_required,
                $challenge->id,
                now()->endOfWeek()->startOfDay(),
                now()->endOfWeek()->endOfDay(),
                $challenge->id,
                $challenge->total_visits_required,
                $challenge->total_visits_required,
            ])[0];
            $filtered_logs = [];
            $i = 0;
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
}
?>