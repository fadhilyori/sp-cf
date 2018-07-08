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
    include "api/DiagnosaController.php";

    $response = array();
    $list_command = ["login", "register", "getAllDiagnosa", "addDiagnosa", "updateDiagnosa", "getAllGejala", "getAllGejalaWithDiagnosa", "updateGejala", "submitKonsultasi", "addRelasi"];
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
                if ($isSuccess) {
                    $response["username"] = $result[0];
                    $response["password"] = $result[1];
                    $response["level"] = $result[2];
                }
                break;
            case 'register':
                try {
                    $result = register($db, $_POST['username'], $_POST['password']);
                    $response["isSuccess"] = $result;
                } catch (Exception $e) {
                    $response["isSuccess"] = false;
                }
                break;
            case 'getAllDiagnosa':
                $result = getAllListDiagnosa($db);
                $response = $result;
                break;
            case 'addDiagnosa':
                try {
                    $result = addDiagnosa($db, $_POST['kode_diagnosa'], $_POST['nama_diagnosa'], $_POST['keterangan']);
                    $response["isSuccess"] = $result;
                    if ($result) {
                        $response["kode_diagnosa"] = $_POST['kode_diagnosa'];
                    } else {
                        $response["error"] = "kode diagnosa kembar";
                    }
                } catch (Exception $e) {
                    $response["isSuccess"] = false;
                    $response["error"] = $e->getMessage();
                }
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
                // $response['gejala_temp'] = $gejala_temp;
                break;
            case 'addRelasi':
                $result = addRelasi($db, $_POST['kode_diagnosa'], $_POST['kode_gejala'], $_POST['mb'], $_POST['md']);
                $response['isSuccess'] = $result;
                if ($result) {
                    $response['kode_gejala'] = $_POST['kode_gejala'];
                    $result2 = getGejalaWithKodeGejala($db, $_POST['kode_gejala']);
                    $response['nama_gejala'] = $result2['nama_gejala'];
                    $response['keterangan'] = $result2['keterangan'];
                }
                break;
            case 'deleteRelasi':
                $result = delRelasi($db, $_POST['kode_diagnosa'], $_POST['kode_gejala']);
                $response['isSuccess'] = $result;
                if ($result) {
                    $response['kode_gejala'] = $_POST['kode_gejala'];
                    $result2 = getGejalaWithKodeGejala($db, $_POST['kode_gejala']);
                    $response['nama_gejala'] = $result2['nama_gejala'];
                    $response['keterangan'] = $result2['keterangan'];
                }
                break;
        }
    }

    echo json_encode($response);