// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here, other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/7.15.5/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.15.5/firebase-messaging.js');
importScripts('https://www.gstatic.com/firebasejs/7.15.5/firebase-firestore.js');
// <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-app.js"></script>

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.

var firebaseConfig = {
    apiKey: "AIzaSyA6i0L2F8RrJ13E0dRCZWdgJMWnzKx-x30",
    authDomain: "halaalmadi-e8464.firebaseapp.com",
    databaseURL: "https://halaalmadi-e8464.firebaseio.com",
    projectId: "halaalmadi-e8464",
    storageBucket: "halaalmadi-e8464.appspot.com",
    messagingSenderId: "51100198139",
    appId: "1:51100198139:web:1e7f13b469cd102a4ffc5e",
    measurementId: "G-LYPYW0D2ZZ"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = 'Background Message Title';
    const notificationOptions = {
        body: 'Background Message body.',
        icon: '/firebase-logo.png'
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);

});

