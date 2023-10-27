<?php
namespace App\Traits;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\NotificationSeen;
use App\Models\NotificationConfig;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        $notifiction_type_arr   = ["arts", "comp feedback"];
        $user_email             = Auth::user()->email;
        $user                   = User::find($user_id);
        $deleted_time           = NotificationConfig::where('user_id', $user_id)->first()->time_id ?? 0;
        $user_created_orders    = $user->orders->pluck('id');
        $notifications_list     = Notification::with(['NotificationSeen'  => function($q) use ($user_id){
                                    $q->where('seen_by_id', '=', $user_id);
                                }])
                                ->where('time_id', '>', $deleted_time)
                                ->limit(4)
                                ->orderBy('id', 'desc');
        if($user_email == "art@nuworldgraphicslv.com"){
            $notifications_list     = $notifications_list->whereIn("type", $notifiction_type_arr);
        }else{
            $notifications_list     = $notifications_list->whereIn("idFK", $user_created_orders);
            $notifications_list     = $notifications_list->whereNotIn("type", $notifiction_type_arr);

        }
        $notifications_list     = $notifications_list->get();
        $notifications_arr      = $notifications_list->pluck('id');
        $notification_count     = Notification::doesntHave('NotificationSeen')->whereIn("id", $notifications_arr)->where('time_id', '>', $deleted_time);
        if($user_email == "art@nuworldgraphicslv.com"){
            $notification_count     = $notification_count->whereIn("type", $notifiction_type_arr);
        }
        $notification_count     = $notification_count->get()->count();
        $html                   = '';
        if(count($notifications_list) > 0){
            foreach($notifications_list as $notification){
                $envelop    = (isset($notification->NotificationSeen->seen_by_id) && $notification->NotificationSeen->seen_by_id == $user_id) ? "fa-envelope-open":"fa-envelope";
               
                $nt_id    = (isset($notification->NotificationSeen->seen_by_id) && $notification->NotificationSeen->seen_by_id == $user_id) ? 0: $notification->id;
                $html   .= '<div class="row"><div class="col-md-10"><div class="media new">
                        <div class="media-body">
                            <a href="'.route("admin.orders.index").'"><h6>'.$notification->body.'</h6></a>
                            <span>'.date('m-d-Y h:i:s', $notification->time_id).'</span>
                        </div>
                    </div></div><div class="col-md-2"><div style="width:20%"><i style="cursor: pointer;" data-nt-id="'.$nt_id.'" class="fas '.$envelop.'"></i></div></div></div>';
            }
        }
        $html       .= '';
        return json_encode(["html"=>$html, "count"=>$notification_count]);
    }
    function all_notification_list($user_id){
        $user                   = User::find($user_id);
        $user_created_orders    = $user->orders->pluck('id');
        $deleted_time           = NotificationConfig::where('user_id', $user_id)->first()->time_id ?? 0;
    
        $notifications_list     = Notification::with(['NotificationSeen'  => function($q) use ($user_id){
            $q->where('seen_by_id', '=', $user_id);
        }])->where('time_id', '>', $deleted_time)->get();
        return $notifications_list;
    }

    function notification_seen($nt_id, $seen_by_id){

        NotificationSeen::create(["notification_id"=>$nt_id, "seen_by_id"=>$seen_by_id]);
        return true;
    }
}