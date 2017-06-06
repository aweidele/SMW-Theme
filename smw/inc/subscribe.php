<?php
header('Content-Type: application/json');
$data = [
    'email'     => $_POST['EMAIL'],
    'status'    => 'subscribed',
    'firstname' => $_POST['FNAME'],
    'lastname'  => $_POST['LNAME']
];

$mc = syncMailchimp($data);

if($mc[0] == 200) {
  $message = array('greeting' => 'Thank you for subscribing to the SM&W Newsletter');
} else {
  $result = json_decode($mc[1]);
  $message = array('greeting' => 'Error: '.$result->detail);
}

echo json_encode($message);

function syncMailchimp($data) {
    $apiKey = '66762c487a761ba22fa7e045c1cb702b-us3';
    $listId = 'caa7a9940a';

    $memberId = md5(strtolower($data['email']));
    $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

    $json = json_encode([
        'email_address' => $data['email'],
        'status'        => $data['status'], // "subscribed","unsubscribed","cleaned","pending"
        'merge_fields'  => [
            'FNAME'     => $data['firstname'],
            'LNAME'     => $data['lastname']
        ]
    ]);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                                                                 

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return array($httpCode,$result);
}

?>