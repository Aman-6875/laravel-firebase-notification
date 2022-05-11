<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
class WebNotificationController extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('home');
    }
  
    public function storeToken(Request $request)
    {
        dd($request->all());
        auth()->user()->update(['device_key'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }
  
    public function sendWebNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        // $url = 'https://durbar.live/';
        $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();
          
        $serverKey = 'AAAA-96gxLo:APA91bHx4TcrGS5bFcp-xTwkPBYh0wmn26VgwSiRfV5mrKVRNMIjvYQQs9X24bU__ZKJM5_KlvgkQaaYFsPagXAXxvkO0B2nZLv9mBciANf8X2xMMdC1K8haPhtNmtIf3ysAzlSSuJNO';
  
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body, 
                "icon"=>"https://static.durbar.live/general/durbar-white-logo-png-file-2.png",
                'link' => 'https://github.com/'

            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
        dd($result);        
    }
}