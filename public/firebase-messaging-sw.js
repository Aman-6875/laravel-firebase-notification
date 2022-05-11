// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyBectANu-7jo7cimDL0yvgYsD_HrY_scuk",
    authDomain: "test-web-notification-d5255.firebaseapp.com",
    databaseURL: 'https://test-web-notification-d5255-default-rtdb.asia-southeast1.firebasedatabase.app/',
    projectId: "test-web-notification-d5255",
    storageBucket: "test-web-notification-d5255.appspot.com",
    messagingSenderId: "1081771869370",
    appId: "1:1081771869370:web:99c2984b86513a31456e83",
    measurementId: "G-P49X66P39L"

});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});