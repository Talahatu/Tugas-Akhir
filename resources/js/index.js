import $ from "jquery";
import * as PusherPushNotifications from "@pusher/push-notifications-web";

$(document).ready(function () {
    const token = document
        .querySelector("meta[name=csrf-token]")
        .getAttribute("content");
    $(document).on("click", "#logout", function () {
        // Maybe not used anymore
        // window.navigator.serviceWorker.ready.then(
        //     (serviceWorkerRegistration) => {
        //         const beamsClient = new PusherPushNotifications.Client({
        //             instanceId: "1d20c86a-7a76-4cb2-b6ff-8053628e0303",
        //             serviceWorkerRegistration: serviceWorkerRegistration,
        //         });
        //         console.log(
        //             "Log Out",
        //             beamsClient.getDeviceInterests(),
        //             beamsClient.getUserId(),
        //             beamsClient.userId
        //         );
        //         beamsClient.clearAllState();
        //         beamsClient.stop();
        //     }
        // );
        $(this).parent().submit();
    });

    $("#alertClose").on("click", function () {
        $(this).parent()[0].remove();
    });
    $("#btnSearch").on("click", function () {
        let query = $("#searchInput").val() ? $("#searchInput").val() : "all";
        $(this).attr("href", "/search/" + query);
    });

    $("#btnTesting").on("click", function () {
        console.log("click");
        $.ajax({
            type: "POST",
            url: "/test",
            data: {
                _token: token,
            },
            success: function (response) {
                console.log("Clicked");
                console.log(response);
            },
        });
    });
});
