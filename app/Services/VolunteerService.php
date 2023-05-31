<?php


namespace App\Services;

use App\Models\Attendance;
use App\Models\Event;
use Hash;
use HelperConstants;
use App\Models\Volunteer;
use Illuminate\Support\Facades\DB;
use App\Services\Common\UserService;


class VolunteerService extends UserService
{

    public function __construct()
    {
        $this->model = new Volunteer;
    }

    public function updateLocation(object $request)
    {
        $collection = collect($request->all());
    }

    public function create(object $request)
    {

        $collection = collect($request->all());

        $volunteer_id = $this->genVolunteerId();
        $refferal_url = $this->genReferralUrl();
        $name = $collection->get('name', '');
        $name_ar = $collection->get('name_ar', '');
        $email = $collection->get('email', '');
        $password = Hash::make($collection->get('password', ''));
        // $phone = $collection->get('phone', '');

        $phone = $collection->get('format_international', '');
        $format_international = $collection->get('format_international', '');
        $country_calling_code = $collection->get('country_calling_code', '');
        $country_code = $collection->get('country_code', '');

        if ($collection->get('status')) {
            $status = $collection->get('status', Volunteer::ACTIVE_STATUS);
            $verified = 1;
        } else {
            $status = $collection->get('status', Volunteer::PENDING_STATUS);
            $verified = 1;
        }

        // To be Delete in production
        // $status = 1;
        // $verified = 1;

        $gender = $collection->get('gender', '');
        $dob = $collection->get('dob', null);
        $emirates_id = $collection->get('emirates_id', '');
        $emirates_id_expiry = $collection->get('emirates_id_expiry', null);
        $nationality = $collection->get('nationality', '');
        $hear_about_us = $collection->get('hear_about_us', null);
        $languages = $collection->get('languages', null);

        $refferal_account_id = $this->getRefferalAccount($collection->get('refferal_url', null));

        $emirates_id_photo_back = $emirates_id_photo = $photo = '';

        if ($request->has('emirates_id_photo')) {
            $saveFile = saveFile($request->emirates_id_photo, HelperConstants::EMIRATES_ID_DIRECTORY,  HelperConstants::UPLOAD_DISK);
            $emirates_id_photo = $saveFile['fileName'];
        }

        if ($request->has('emirates_id_photo_back')) {
            $saveFile = saveFile($request->emirates_id_photo_back, HelperConstants::EMIRATES_ID_DIRECTORY,  HelperConstants::UPLOAD_DISK);
            $emirates_id_photo_back = $saveFile['fileName'];
        }

        $collection = collect();
        $volunteer = $collection->merge(
            compact('volunteer_id', 'name', 'name_ar', 'email', 'password', 'phone', 'status', 'gender', 'dob', 'emirates_id', 'emirates_id_expiry', 'nationality', 'photo', 'emirates_id_photo', 'emirates_id_photo_back', 'refferal_url', 'hear_about_us', 'refferal_account_id', 'languages', 'verified', 'format_international', 'country_calling_code', 'country_code')
        )->toArray();


        // Create Volunteer Here
        $user = $this->model->create($volunteer);

        if ($user->status != 1) {
            $this->sendAccountVerification($user);
        }

        return $user;
    }

    public function update(object $request, $id)
    {
        $volunteer = $this->model->find($id);

        $volunteer->name = $request->name ?  $request->name : $volunteer->name;
        $volunteer->name_ar = $request->name_ar ?  $request->name_ar : $volunteer->name_ar;
        $volunteer->phone = $request->phone ?  $request->phone : $volunteer->phone;

        if ($request->has('status')) {
            $volunteer->status = $request->status ?  $request->status : $volunteer->status;
        }

        $volunteer->gender = $request->gender ?  $request->gender : $volunteer->gender;
        $volunteer->dob = $request->dob ?  $request->dob : $volunteer->dob;

        $volunteer->refferal_url = $request->refferal_url ?  $request->refferal_url : $volunteer->refferal_url;


        // allow emirates id to be change ?
        $volunteer->emirates_id = $request->emirates_id ?  $request->emirates_id : $volunteer->emirates_id;

        $volunteer->emirates_id_expiry = $request->emirates_id_expiry ?  $request->emirates_id_expiry : $volunteer->emirates_id_expiry;
        $volunteer->nationality = $request->nationality ?  $request->nationality : $volunteer->nationality;

        $volunteer->format_international = $request->format_international ?? $volunteer->format_international;
        $volunteer->country_calling_code = $request->country_calling_code ?? $volunteer->country_calling_code;
        $volunteer->country_code = $request->country_code ?? $volunteer->country_code;

        if ($request->has('emirates_id_photo')) {
            $volunteer->emirates_id_photo ? deleteFile(HelperConstants::EMIRATES_ID_DIRECTORY . $volunteer->emirates_id_photo, HelperConstants::UPLOAD_DISK) : '';
            $saveFile = saveFile($request->emirates_id_photo, HelperConstants::EMIRATES_ID_DIRECTORY,  HelperConstants::UPLOAD_DISK);
            $volunteer->emirates_id_photo = $saveFile['fileName'];
        }

        if ($request->has('emirates_id_photo_back')) {
            $volunteer->emirates_id_photo_back ? deleteFile(HelperConstants::EMIRATES_ID_DIRECTORY . $volunteer->emirates_id_photo_back, HelperConstants::UPLOAD_DISK) : '';
            $saveFile = saveFile($request->emirates_id_photo_back, HelperConstants::EMIRATES_ID_DIRECTORY,  HelperConstants::UPLOAD_DISK);
            $volunteer->emirates_id_photo_back = $saveFile['fileName'];
        }

        if ($request->has('photo')) {
            $volunteer->photo ? deleteFile(HelperConstants::LOGO_DIRECTORY . $volunteer->photo, HelperConstants::UPLOAD_DISK) : '';
            $saveFile = saveFile($request->photo, HelperConstants::LOGO_DIRECTORY, HelperConstants::UPLOAD_DISK);
            $volunteer->photo = $saveFile['fileName'];
        }

        $volunteer->education = $request->education ?  $request->education : $volunteer->education;
        $volunteer->disease = $request->disease ?  $request->disease : $volunteer->disease;
        $volunteer->languages = $request->languages ?  $request->languages : $volunteer->languages;
        $volunteer->job = $request->job ?  $request->job : $volunteer->job;
        $volunteer->skills = $request->skills ?  $request->skills : $volunteer->skills;
        $volunteer->interest = $request->interest ?  $request->interest : $volunteer->interest;

        $volunteer->emergency_contact_name = $request->emergency_contact_name ?  $request->emergency_contact_name : $volunteer->emergency_contact_name;
        $volunteer->emergency_contact_no = $request->emergency_contact_no ?  $request->emergency_contact_no : $volunteer->emergency_contact_no;

        $volunteer->save();

        return $volunteer;
    }

    private function getRefferalAccount($url = null)
    {
        if (!$url) return null;

        $account = $this->model->where('refferal_url', $url)->first();
        return $account ? $account->id : null;
    }

    private function genVolunteerId()
    {

        return 'D4D-' . time();
    }

    private function genReferralUrl()
    {
        $folder = '/day4dubai';
        $base_url = 'https://day4dubai.onlinetestingserver.com';
        return $base_url . $folder . '/q?refferral=' . time() . rand(1000, 9999);
    }

    public function invitation($request, $volunteerId, $pagination)
    {
        $events = $this->model->where('id', $volunteerId)->first();
        $events = $events->invitations();
        $events = $events->whereHas('category', function ($q) {
            $q->where('status', 1);
        });

        $eventService = new EventService;

        $events = $eventService->filterEventData($events, $request);

        $events =  $events->orderBy('created_at', 'desc');
        return $events->paginate($pagination);
    }

    public function myEvents($request, $volunteerId, $pagination)
    {
        $events = $this->model->where('id', $volunteerId)->first();

        if ($request->has('label') && $request->label == 'requested') {

            $events = $events->requested();
        } else {

            $events = $events->myJoinedEvents();
        }

        $events = $events->with(['category', 'organization', 'schedules']);

        $events->whereHas('category', function ($q) {
            $q->where('status', 1);
        });

        $eventService = new EventService;


        $events = $eventService->filterEventData($events, $request);

        $events->orderBy('id', 'DESC');
        return $events->paginate($pagination);
    }

    public function getLogs($request, $volunteerId, $pagination)
    {
        $data = $this->model->find($volunteerId);

        return $data->myLog()->paginate($pagination);
    }

    public function logDetails($userId, $eventId)
    {
        $volunteer = $this->model->where('id', $userId)->first();

        $eventDetails = $volunteer->event()->with(['attendance', 'event.organization', 'event.category', 'event.participants', 'event.schedules'])->where('event_id', $eventId)->get();

        return $eventDetails;
    }

    public function logDetailsEvent($eventId)
    {
        $volunteer = Event::where('id', $eventId)->with(['category', 'participants.volunteer', 'schedules'])->first();

        return $volunteer;
    }


    public function getCertificates($request, $volunteerId, $pagination)
    {

        $data = $this->model->find($volunteerId);
        return $data->awardedCertificates()->with(['event.certificates.certificate', 'event.organization', 'event.category', 'event.schedules'])
            ->orderBy('id', 'DESC')
            ->groupBy('event_id')
            ->paginate($pagination);
    }

    public function getReviews($volunteer, $pagination)
    {
        $data = $volunteer->reviews()->paginate($pagination);
        return $data;
    }

    public function search($request)
    {
        return $this->model
            // ->when(request()->filled('volunteering_hours'), function ($q) {
            //     $q->addSelect([
            //         '*',
            //         'spendHours' => Attendance::selectRaw('IFNULL(SUM(TIMESTAMPDIFF(MINUTE, check_in, check_out)) / 60,0)')
            //             ->join('event_participants', 'event_participants.id', 'attendances.event_participant_id')
            //             ->whereColumn('event_participants.volunteer_id', 'volunteers.id')
            //     ])
            //         ->having('spendHours', '>', request('volunteering_hours'));
            // })
            ->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
                $q->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->when(request()->filled('gender'), function ($q) {
                if (request('gender') != 'Both') {
                    $q->where('gender', request('gender'));
                }
            })
            ->when(request()->filled('nationality'), function ($q) {
                $q->whereIn('nationality', explode(',', request('nationality')));
            })
            // ->when(request()->filled('rating'), function ($q) {
            //     $q->whereHas('avgRating', function ($q) {
            //         return $q->where('rating_avg', '>=', request('rating'));
            //     });
            // })
            // ->when(request('location'), function ($q) {
            //     $q->whereHas('location', function ($q) {
            //         return $q->where('text', 'like', '%' . request('location') . '%');
            //     });
            // })
            ->when(request('min_age'), function ($q) {
                $q->whereRaw('(SELECT DATE_FORMAT(FROM_DAYS( DATEDIFF( CURDATE(), dob ) ), "%Y")+0 as age) between ? and ?', [request('min_age'), request('max_age')]);
            })
            ->limit(20)->get();
    }

    public function totalAttendedEvents($volunteer)
    {
        return $volunteer->myEvent()->count();
    }

    public function totalSpentHours($volunteer)
    {
        return $volunteer->spentHours()->get()->sum('spendHours');
    }
}
