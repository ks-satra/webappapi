<script>
var onlineUser;
</script>
<script type="module">
import {
    initializeApp
} from "https://www.gstatic.com/firebasejs/9.6.0/firebase-app.js";
import {
    getDatabase,
    ref,
    push,
    set,
    onValue,
    onDisconnect,
    serverTimestamp
} from "https://www.gstatic.com/firebasejs/9.6.0/firebase-database.js";
$(function() {
    var ALL_USER = [];
    const firebaseConfig = {
        apiKey: "AIzaSyDevNJq85X-3hxJyDmMlSZ28RH6uVOyqoQ",
        authDomain: "esopidthongonlineuser.firebaseapp.com",
        databaseURL: "https://esopidthongonlineuser-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "esopidthongonlineuser",
        storageBucket: "esopidthongonlineuser.appspot.com",
        messagingSenderId: "741493433051",
        appId: "1:741493433051:web:79a8890183509b688d22fe",
        measurementId: "G-JWTE5S4EEW"
    };
    const app = initializeApp(firebaseConfig);
    const database = getDatabase(app);
    const usersRef = ref(database, 'users/');
    const userRef = ref(database, 'users/' + USER.user_id);
    set(userRef, setData(true));
    onDisconnect(userRef).set(setData(false));
    onValue(usersRef, (snap) => {
        ALL_USER = [];
        snap.forEach(function(childSnapshot) {
            var key = childSnapshot.key;
            var val = childSnapshot.val();
            ALL_USER.push(val);
        });
    });

    function setData(status) {
        var user = JSON.parse(JSON.stringify(USER));
        user.online = status;
        user.updated = serverTimestamp();
        return user;
    }

    onlineUser = function(opt) {
        var option = {};
        option.onOnline = opt.onOnline || function() {};
        option.onOffline = opt.onOffline || function() {};
        if (option.onOnline || option.onOffline) {
            onValue(usersRef, (snap) => {
                var user_online = [];
                var user_offline = [];
                var len = ALL_USER.length;
                for (var i = 0; i < len; i++) {
                    if (ALL_USER[i].online) {
                        user_online.push(ALL_USER[i]);
                    } else {
                        user_offline.push(ALL_USER[i]);
                    }
                }
                if (option.onOnline) option.onOnline(user_online);
                if (option.onOffline) option.onOffline(user_offline);
            });
        }
    }
});
</script>