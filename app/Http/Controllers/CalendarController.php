<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CalendarController extends Controller
{
    private $tenantId = 'e0c49df4-8848-42cf-8942-0438105254ec';
    private $clientId = 'b7e41036-5fa0-4b10-947d-89f010a3ccb4';
    private $clientSecret = '~cC8Q~FJQjFN80cz6n2jxuJUONQSy42b3bWOedp3';
    private $grantType = 'client_credentials';
    private $scope = 'https://graph.microsoft.com/.default';
    private $userPrincipalName = 'Ravi.s@qitsolution.co.in';



    public function methodName(Request $request)
    {
        $meetingDate = $request->input('meetingDate');
        echo $meetingDate;
        $url = "https://login.microsoftonline.com/{$this->tenantId}/oauth2/v2.0/token";
        
        $response = Http::asForm()->post($url, [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => $this->grantType,
            'scope' => $this->scope,
        ]);
        
        $data = $response->json();
        
        $myMeets = $this->getSchedule($data['access_token'], $meetingDate);
        // $schedules = $this->scheduleMeeting($data['access_token']);
        // $availableTimes = $myMeets['value'][0]['availabilityView'];
        //$data = json_decode($myMeets)
        // return response()->json([
        //     'data' => $myMeets['value'][0]
        // ]);
        //return response()->json($myMeets);
        
        // return response()->json([
        //     'data'=>$schedules
        // ]);
        // $availabilityView = $myMeets['data']['availabilityView'];
        // return $availabilityView;
        $apiresponse = json_decode($myMeets);
        return $myMeets;
    }

    private function getSchedule($accessToken,$meetingDate)
    {
        $apiEndpoint = 'https://graph.microsoft.com/v1.0/users/'.$this->userPrincipalName.'/calendar/getSchedule';

        $headers = [
            'Prefer' => 'outlook.timezone="India Standard Time"',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$accessToken,
        ];
        $reqBody = [
            "schedules" => ["Ravi.s@qitsolution.co.in"],
            "startTime" => [
                "dateTime" => $meetingDate."T11:00:00",
                "timeZone" => "India Standard Time"
            ],
            "endTime" => [
                "dateTime" => $meetingDate."T18:00:00",
                "timeZone" => "India Standard Time"
            ],
            "availabilityViewInterval" => 60
        ];

        $response = Http::withHeaders($headers)->post($apiEndpoint, $reqBody);

        // $data = $response->json();

        return $response;
    }
    private function scheduleMeeting( $config)
    {
        // first get the token:
        // $url = "https://login.microsoftonline.com/{$this->tenantId}/oauth2/v2.0/token";
        
        // $response = Http::asForm()->post($url, [
        //     'client_id' => $this->clientId,
        //     'client_secret' => $this->clientSecret,
        //     'grant_type' => $this->grantType,
        //     'scope' => $this->scope,
        // ]);
        
        // $data = $response->json();
        // $accessToken = $data['access_token'];

        // $apiEndpoint = 'https://graph.microsoft.com/v1.0/users/'.$this->userPrincipalName.'/calendar/events';

        // $headers = [
        //     'Content-Type' => 'application/json',
        //     'Authorization' => 'Bearer '.$accessToken,
        // ];
        // $reqbody = [
        //     "subject" => "Business Discussion",
        //     "body" => [
        //         "contentType" => "HTML",
        //         "content" => "Please Confrim the joining status of the meeting.."
        //     ],
        //     "start" => [
        //         "dateTime" => "2023-03-11T12:00:00",
        //         "timeZone" => "India Standard Time"
        //     ],
        //     "end" => [
        //         "dateTime" => "2023-03-11T13:00:00",
        //         "timeZone" => "India Standard Time"
        //     ],
        //     "location" => [
        //         "displayName" => "Online Teams Meeting"
        //     ],
        //     "attendees" => [
        //         [
        //             "emailAddress" => [
        //                 "address" => "ravi.shrma@zohomail.in",
        //                 "name" => "Ravi Sharma"
        //             ],
        //             "type" => "required"
        //         ]
        //     ],
        //     "isOnlineMeeting" => true,
        //     "onlineMeetingProvider" => "teamsForBusiness"
        // ];
        
        // //$reqBodyJson = json_encode($reqbody);
         

        // $response = Http::withHeaders($headers)->post($apiEndpoint, $reqbody);
            dd($config);
    }

    //STEP 1
    // public function findMeetingSlots (){
    //     $token = $this->methodName()
    // }


// ----------- conversion of the values -------------------
//     $selectedSlot = "11";
// $selectedSlotInt = intval($selectedSlot);
// $selectedSlotInt++;
// $selectedSlot = strval($selectedSlotInt);

// Now $selectedSlot has the value "12"

    // private $reqBody = [
    //     "schedules" => ["Ravi.s@qitsolution.co.in"],
    //     "startTime" => [
    //         "dateTime" => $fullDate . $selectedSlot . $appendZone,
    //         "timeZone" => "India Standard Time"
    //     ],
    //     "endTime" => [
    //         "dateTime" => $fullDate . $selectedSlot . $appendZone,
    //         "timeZone" => "India Standard Time"
    //     ],
    //     "availabilityViewInterval" => 60
    // ];

// Extracting the values from the request:
// private function scheduleMeeting(Request $request, $accessToken)
// {
//     $dateTime = $request->input('dateTime');
//     $selectedSlots = $request->input('selectedSlots');

//     // Use the variables in your code
//     // For example:
//     $startTime = [
//         "dateTime" => $dateTime,
//         "timeZone" => "India Standard Time"
//     ];

//     // ...
// }    
    
}
