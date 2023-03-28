<?php

use App\Models\Activity;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Request;

function generateTicketID($start = 0, $length = 12) {
	$code = mt_rand(10000, 999999999999);
	$currentTime = time();
	return substr('TK'.str_shuffle($currentTime . $code), $start, $length);
}

function tinyUrl($url) {
	$tiny = 'http://tinyurl.com/api-create.php?url='.$url;
	return file_get_contents($tiny);
	// return $url;
}

function tinyUrlTesting($url) {
	$tiny = 'http://tinyurl.com/api-create.php?url=';
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$tiny.urlencode(trim($url)) );
	$response = curl_exec($ch);
	curl_close($ch);
	/* $response = \Http::post($tiny,[
		'url' => $url
	]);
	return $response; */
	// return $response;
}
function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
        else return FALSE;
    }
function prepare_text($text, $data = []) {

	return str_replace(array_keys($data), array_values($data), $text);
}

function randomSupportAdmin($identifier = 'supports.internal.actions', $exclude = []) {
	return Admin::query()->where('status', 1)->inRandomOrder()->whereRaw('role IN
        (
        SELECT
            role_id
        FROM
            role_permissions
        WHERE
        permission_id IN
        (
        SELECT
            id
        FROM
            permissions_list
        WHERE
            identifier = ?
        ) AND
        value = ?
    )', ['identifier' => $identifier, 'value' => 1])
		->where('id', '!=', auth('admin')->id())
		->when(count($exclude) > 0, function ($q) use ($exclude) {
			$q->whereNotIn('id', $exclude);
		})
		->first();
}

function frontend_url($string) {
	return config('app.frontend_url') . '/' . $string;
}

function pendingRequestsCount($userId, $requestId = null) {
	return Request::whereIn('status', ['pending', 'assigned'])
		->when(!empty($requestId), function ($q) use ($requestId) {
			$q->where('id', '!=', $requestId);
		})
		->where(function ($q) use ($userId) {
			$q->where('requested_by', $userId)
				->orWhere('admin_id', $userId)
				->orWhere('passed_to', $userId);
		})->count();
}

function getSmilesBalanace($userId = null) {
	if (!$userId) {
		$userId = auth()->id();
	}

	$amount = DB::select('SELECT IFNULL((SELECT SUM(value) FROM user_smiles WHERE user_id = ? AND type = ?),0) as out_amount, IFNULL((SELECT SUM(value) FROM user_smiles WHERE user_id = ? AND type = ?),0) as in_amount', [$userId, 'out', $userId, 'in']);
    $amount = end($amount);
	return abs($amount->in_amount - $amount->out_amount);
}

function getWalletBalanace($userId = null,$type = 'credit') {
	if (!$userId) {
		$userId = auth()->id();
	}

	$amount = DB::select('SELECT IFNULL((SELECT SUM(value) FROM wallet WHERE user_id = ? AND flow = ? AND type = ?),0) as out_amount, IFNULL((SELECT SUM(value) FROM wallet WHERE user_id = ? AND flow = ? AND type = ?),0) as in_amount', [$userId, 'out',$type, $userId, 'in',$type]);
    $amount = end($amount);
	return abs($amount->in_amount - $amount->out_amount);
}



function point2point_distance($lat1, $lon1, $lat2, $lon2, $unit='K') 
    { 
        if(!$lat1 || !$lat2 || !$lon1 || !$lon2) {
            return '0';
        }
        $theta = $lon1 - $lon2; 
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
        $dist = acos($dist); 
        $dist = rad2deg($dist); 
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344); 
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    function getCurrentDateString()
    {
        $ds = Carbon::now();
        return $ds->toDateString();
    }

    function activity($params){
            Activity::create($params);
    }