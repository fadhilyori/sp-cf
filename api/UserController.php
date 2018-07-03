<?php

    // -----------RETURN-----------
    // {
    //      "isSuccess" = true,
    //      "level" = "user"
    // }

    function login($db, $username, $password) {
        $result = mysqli_query($db, "SELECT * FROM cf_admin WHERE user='$username' AND pass='$password'");
        if (mysqli_fetch_array($result) > 0) {
            $result_level = mysqli_query($db, "SELECT level FROM cf_admin WHERE user='$username' AND pass='$password'");
            $level = mysqli_fetch_array($result_level)[0];
        } else {
            $level = "";
        }
        return $level;
    }

    // -----------RETURN-----------
    // {
    //      "isSuccess" = true
    // }

    function register($db, $username, $password) {
        if (mysqli_query($db, "INSERT INTO cf_admin (user, pass, level) VALUES ('$username', '$password', 'user')") == true) {
            $isSuccess = true;
        } else {
            $isSuccess = false;
        }

        return $isSuccess;
    }