<?php
namespace App\Traits;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\NotificationSeen;
/**
 * Trait NotificationTrait
 * @package App\Http\Traits
 */
trait NotificationTrait
{

    function add_notification($data=[]){
        if(count($data) > 0){

            Notification::create($data);
        }
        
    }

    function notification_list($user_id){

        $notifications_list     = Notification::with(['NotificationSeen'  => function($q) use ($user_id){
                                    $q->where('seen_by_id', '=', $user_id);
                                }])
                                ->limit(4)
                                ->orderBy('id', 'desc')
                                ->get();
        $notification_count     = Notification::doesntHave('NotificationSeen')->get()->count();
        $html                   = '';
        if(count($notifications_list) > 0){
            foreach($notifications_list as $notification){

                $envelop    = (isset($notification->NotificationSeen->seen_by_id) && $notification->NotificationSeen->seen_by_id == $user_id) ? "fa-envelope-open":"fa-envelope";
               
                $nt_id    = (isset($notification->NotificationSeen->seen_by_id) && $notification->NotificationSeen->seen_by_id == $user_id) ? 0: $notification->id;
            $html   .= '<div class="row"><div class="col-md-10"><div class="media new">
                        <div class="media-body">
                            <h6>'.$notification->body.'</h6>
                            <span>'.date('m-d-Y h:i:s', $notification->time_id).'</span>
                        </div>
                    </div></div><div class="col-md-2"><div style="width:20%"><i style="cursor: pointer;" data-nt-id="'.$nt_id.'" class="fas '.$envelop.'"></i></div></div></div>';
            }
        }
        $html       .= '';
        return json_encode(["html"=>$html, "count"=>$notification_count]);
    }
    function all_notification_list($user_id){

        $notifications_list     = Notification::with(['NotificationSeen'  => function($q) use ($user_id){
            $q->where('seen_by_id', '=', $user_id);
        }])->get();
        return $notifications_list;
    }

    function notification_seen($nt_id, $seen_by_id){

        NotificationSeen::create(["notification_id"=>$nt_id, "seen_by_id"=>$seen_by_id]);
        return true;
    }
}