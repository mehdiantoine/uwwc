"use strict";

$(function(){

    $('#loginForm').submit(function(){

        //event.preventDefault();

        var data = {

            user:     JSON.stringify("MEHDI"),
            password: JSON.stringify("7f7d49795dcf0a82605fb1103ed20d28")

        };

        /**
         **************
         ** AJAX
         *
         * type:        POST
         * destination: login.php
         */

        $.post(

            //URL
            '../../login.php',

            data,

            function singinInSuccess (){
                //AJAX success
                window.alert('You are connected');
            },

            //data type
            JSON

        );

    });

});

