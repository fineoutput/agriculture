<?php

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Exception\MessagingException;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        // Path to your service account key
        $serviceAccountPath = APPPATH . 'config/dairy-muneem-firebase-adminsdk-9cc60-10f1283429.json';

        // Initialize Firebase SDK
        $firebase = (new Factory)->withServiceAccount($serviceAccountPath);
    //     $firebase = (new Factory())
    // ->withProjectId('fineoutput3')
    // ->withDatabaseUri('https://fineoutput3.firebaseio.com');

        // Get the Firebase Messaging instance
        $this->messaging = $firebase->createMessaging();
    }

    // Send a notification to a topic
    public function sendNotificationToTopic($topic, $title, $body, $data = [])
    {
        // Create a topic message
        $message = CloudMessage::withTarget('topic', $topic)
            ->withNotification([
                'title' => $title,
                'body' => $body,
            ]);
            // ->withData($data); // Optional custom data

        // Send the notification
        try {
            $result = $this->messaging->send($message);
            return ['success' => true, 'result' => $result];
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
