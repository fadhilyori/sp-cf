<?php

    // -----------RETURN-----------
    // {
    //      "isSuccess" = true,
    //      "level" = "user"
    // }

    function login($db, $username, $password) {
        $result = mysqli_query($db, "SELECT * FROM cf_admin WHERE user='$username' AND pass='$password'");
        $response = [];
        if (mysqli_fetch_array($result) > 0) {
            $result = mysqli_query($db, "SELECT * FROM cf_admin WHERE user='$username' AND pass='$password'");
            $q = mysqli_fetch_array($result);
            array_push($response, $q['user']);
            array_push($response, $q['pass']);
            array_push($response, $q['level']);
        } else {
            $response = "";
        }
        return $response;
    }

    // -----------RETURN-----------
    // {
    //      "isSuccess" = true
    // }

    function register($db, $username, $password) {
        $result = mysqli_query($db, "INSERT INTO cf_admin (user, pass, level) VALUES ('$username', '$password', 'user')");
        return $result;
    }