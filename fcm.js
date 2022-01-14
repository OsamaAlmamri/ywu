// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyDEcBVuKQk8ionFo3MR4K4zkb7BQ9baTXs",
  authDomain: "yemenwe-d2ed4.firebaseapp.com",
  projectId: "yemenwe-d2ed4",
  storageBucket: "yemenwe-d2ed4.appspot.com",
  messagingSenderId: "752937676482",
  appId: "1:752937676482:web:ce642e226e3ec88717d55b",
  measurementId: "G-DS5Z7LJJTR"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
