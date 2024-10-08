<?php

namespace App\CentralLogics;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use App\Models\BusinessSetting;

class Helpers
{
    public static function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            array_push($err_keeper, ['code' => $index, 'message' => $error[0]]);
        }
        return $err_keeper;
    }

    public static function get_business_settings ($name)
    {
        $config=null;

        $paymentmethod=BusinessSetting::where('key', $name)->first();

        if ($paymentmethod) {
            $config=json_decode(json_encode($paymentmethod->value), true);
            $config=json_decode($config, true);
        }
        return $config;
    }


    public static function currency_code()
    {
        return BusinessSetting::where(['key'=>'currency'])->first()->value;
    }



    public static function send_order_notification($order, $token) {
        try {
            $status = $order->order_status;

            $value=self::order_status_update_message($status);

            if ($value) {
                $data=[
                    'title'=>trans('messages.order_push_title'),
                    'description'=>$value,
                    'order_id'=>$order->id,
                    'image'=>'',
                    'type'=>'order_status',
                ];
                self::send_push_notif_to_device($token, $data);

                try{
                    DB::table('user_notifications')->insert([
                        'data'=>json_encode($data),
                        'ID_client'=>$order->ID_client,
                        'created_at'=>now(),
                        'updated_at'=>now(),
                    ]);
                }catch (\Exception $e) {
                    return response()->json([$e], 403);

                }
            }
            return true;
        }catch (\Exception $e) {
            info($e);
        }
        return false;

    }

    public static function send_push_notif_to_device ($fcm_token, $data, $delivery=0)
    {
        $key=0;
        if($delivery==1){
            $key=BusinessSetting::where(['key'=>'delivery_boy_push_notification_key'])->first()->value;

        }else{
            $key=BusinessSetting::where(['key'=>'push_notification_key'])->first()->value;
        }
        $url="https://fcm.googleapis.com/fcm/send";
        $header=array("authorization: key=" . $key['content'] . "",
            "content-type:application/json"
        );

        $postdata= '{
            "to" : "' . $fcm_token . '",
            "mutable_content": true,
            "data" : {
                "title" : "' . $data['title'] . '",
                "body" : "' . $data['description'] . '",
                "order_id" : "' . $data['order_id'] . '",
                "type" : "' . $data['type'] . '",
                "is_read" : 0
            },
            "notification" : {
                "title" : "' . $data['title'] . '",
                "body" : "' . $data['description'] . '",
                "order_id" : "' . $data['order_id'] . '",
                "title_loc_key" : "' . $data['order_id'] . '",
                "body_loc_key" : "' . $data['type'] . '",
                "type" : "' . $data['type'] . '",
                "is_read" : 0,
                "icon" : "new",
                "android_channel_id" : "dbfood"
            }
        }';





        $ch = curl_init();
        $timeout= 1200;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        //GET URL content
        $result = curl_exec($ch);
        if ($result=== false) {
            dd(curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }





    public static function order_status_update_message($status)
    {
        if($status=='pending'){
            $data=BusinessSetting::where('key', 'order_pending_message')->first()->value;

        }elseif($status=='confirmed'){
            $data=BusinessSetting::where('key', 'order_confirmed_message')->first()->value;
        }elseif($status=='processing'){
            $data=BusinessSetting::where('key', 'order_processing_message')->first()->value;
        }elseif($status=='picked-up'){
            $data=BusinessSetting::where('key', 'out_for_delivery_message')->first()->value;
        }elseif($status=='handover'){
            $data=BusinessSetting::where('key', 'order_handover_message')->first();
        }elseif($status=='delivered'){
            $data=BusinessSetting::where('key', 'order_delivered_message')->first()->value;
        }elseif($status=='delivery_boy_delivered') {
            $data=BusinessSetting::where('key', 'delivery_boy_delivered')->first();
        }elseif($status=='accepted'){
            $data=BusinessSetting::where('key', 'delivery_boy_assign_message')->first();
        }elseif($status=='canceled'){
            $data=BusinessSetting::where('key', 'order_canceled_message')->first();
        }elseif($status=='refounded'){
            $data=BusinessSetting::where('key', 'order_refounded_message')->first();
        }else{
            $data='{"status":"0","message":""}';
        }

        return $data['value']['message'];
}


}
