/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts("https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js");
importScripts(
    "https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"
);

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    apiKey: "AIzaSyDR6VjgImJL9HEpS6AA8OjFwFAHm_2TSn0",
    authDomain: "laravel-firebase-94337.firebaseapp.com",
    projectId: "laravel-firebase-94337",
    storageBucket: "laravel-firebase-94337.appspot.com",
    messagingSenderId: "390767356812",
    appId: "1:390767356812:web:c7fccbac7f7f59f831c4a9",
    databaseURL: "https://laravel-firebase-94337.firebaseio.com",
    measurementId: "G-BFRXJG1H1C",
    // measurementId: "G-R1KQTR3JBN"
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload
    );
    // Customize notification here
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions
    );
});
