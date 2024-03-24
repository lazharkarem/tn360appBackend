<?php
namespace App\Http\Controllers;

class MyController extends Controller
{
public function bulksend(Request $req){
     $url = 'https://fcm.googleapis.com/fcm/send';
     $dataArr = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'id' => $req->id,'status'=>"done");
     $notification = array('title' =>$req->title, 'text' => $req->body, 'image'=> $req->img, 'sound' => 'default', 'badge' => '1',);
     $arrayToSend = array('to' => "/topics/all", 'notification' => $notification, 'data' => $dataArr, 'priority'=>'high');
     $fields = json_encode ($arrayToSend);
     $headers = array (
         'Authorization: key=' . "AAAAS6QK660:APA91bFLJ32qiOG0UqQuuNQdNT9bWMsM0p1jyi6KGYLzTUSa7p5tgYWPSDdd5jJrHThqVlCpEpTZkfb8aJb94S7lG4AD8DLYfUh4U8lOekHVggaCcMi2oeu_f00-EGCxBX4XoBOECgUp",
         'Content-Type: application/json'
     );

     $ch = curl_init ();
     curl_setopt ( $ch, CURLOPT_URL, $url );
     curl_setopt ( $ch, CURLOPT_POST, true );
     curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
     curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
     curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

     $result = curl_exec ( $ch );
     //var_dump($result);
     curl_close ( $ch );
     return $result;
    }
 }
