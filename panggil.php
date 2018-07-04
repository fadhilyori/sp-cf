<?php

    // Config
    $hostname_db = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname_db = "tugasakhir_sp_cf";
    $db = mysqli_connect($hostname_db, $username_db, $password_db, $dbname_db);
    if (!$db) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    include "api/UserController.php";
//    include "api/KonsultasiController.php";
    include "api/DiagnosaController.php";

    $response = array();
    $list_command = ["login", "register", "getAllDiagnosa", "addDiagnosa", "updateDiagnosa", "getAllGejala", "getAllGejalaWithDiagnosa", "updateGejala"];
    if(isset($_GET["panggil"])) {
        switch($_GET["panggil"]) {
            case 'login':
                $result = login($db, $_POST['username'], $_POST['password']);
                if ($result == "") {
                    $isSuccess = false;
                } else {
                    $isSuccess = true;
                }
                $response["isSuccess"] = $isSuccess;
                $response["level"] = $result;
                break;
            case 'register':
                $result = register($db, $_POST['username'], $_POST['password']);
                $response["isSuccess"] = $result;
                break;
            case 'getAllDiagnosa':
                $result = getAllListDiagnosa($db);
                $response = $result;
                break;
            case 'addDiagnosa':
                $result = addDiagnosa($db, $_POST['kode_diagnosa'], $_POST['nama_diagnosa'], $_POST['keterangan']);
                $response["isSuccess"] = $result;
                break;
            case 'updateDiagnosa':
                $result = updateDiagnosa($db, $_POST['kode_diagnosa'], $_POST['nama_diagnosa'], $_POST['keterangan']);
                $response["isSuccess"] = $result;
                break;
            case 'getAllGejala':
                $result = getAllListGejala($db);
                $response = $result;
                break;
            case 'getAllGejalaWithDiagnosa':
                $result = getAllListGejalaWithDiagnosa($db, $_POST['kode_diagnosa']);
                $response = $result;
                break;
            case 'updateGejala':
                $result = updateGejala($db, $_POST['kode_gejala'], $_POST['nama_gejala'], $_POST['keterangan']);
                $response["isSuccess"] = $result;
                break;
            case 'submitKonsultasi':
                include 'config.php';
                $isAPI = true;
                include 'api/KonsultasiController.php';
                $response = $list;
                break;
        }
    }

    echo json_encode($response);


