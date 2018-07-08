<?php
// get list all diagnosa, add diagnosa, update, get list all gejala, get list all gejala that in diagnosa, update
function getAllListDiagnosa($db) {
    $result = mysqli_query($db, "SELECT * FROM cf_diagnosa");
    $list = array();

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $object = array();
            $object["kode_diagnosa"] = $row["kode_diagnosa"];
            $object["nama_diagnosa"] = $row["nama_diagnosa"];
            $object["keterangan"] = $row["keterangan"];
            $object["gejala"] = getAllListGejalaWithDiagnosa($db, $row['kode_diagnosa']);
            array_push($list, $object);
        }
    } else {
        echo "Error : data tidak ditemukan";
    }
    return $list;
}

function addDiagnosa($db, $kode_diagnosa, $nama_diagnosa, $keterangan) {
    if ($kode_diagnosa == null) {
        throw new Exception("null at kode diagnosa");
    } else if ($nama_diagnosa == null) {
        throw new Exception("null at nama diagnosa");
    } else if ($keterangan == null) {
        throw new Exception("null at keterangan");
    }
    mysqli_query($db, "INSERT INTO cf_diagnosa (kode_diagnosa, nama_diagnosa, keterangan) VALUES ('$kode_diagnosa', '$nama_diagnosa', '$keterangan')");
    return true;
}

function updateDiagnosa($db, $kode_diagnosa, $nama_diagnosa, $keterangan) {
    mysqli_query($db, "UPDATE cf_diagnosa SET nama_diagnosa='$nama_diagnosa', keterangan='$keterangan' WHERE kode_diagnosa='$kode_diagnosa'");
    return true;
}

function getAllListGejala($db) {
    $result = mysqli_query($db, "SELECT * FROM cf_gejala");
    $list = array();

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $object = array();
            $object["kode_gejala"] = $row["kode_gejala"];
            $object["nama_gejala"] = $row["nama_gejala"];
            $object["keterangan"] = $row["keterangan"];
            array_push($list, $object);
        }
    } else {
        $list = "Error : data tidak ditemukan";
    }
    return $list;
}

function getAllListGejalaWithDiagnosa($db, $kode_diagnosa) {
    $list_gejala = array();
    $result_gejala_obj = mysqli_query($db, "SELECT * FROM cf_relasi WHERE kode_diagnosa='$kode_diagnosa'");
    if (mysqli_num_rows($result_gejala_obj) > 0) {
        while ($row_obj = mysqli_fetch_array($result_gejala_obj)) {
            $gejala_obj = array();
            $gejala_obj["kode_gejala"] = $row_obj["kode_gejala"];
            $result_gejala_detail = mysqli_query($db,"SELECT * FROM cf_gejala WHERE kode_gejala='$row_obj[kode_gejala]'");
            if (mysqli_num_rows($result_gejala_detail) > 0) {
                while ($row_gejala_obj = mysqli_fetch_array($result_gejala_detail)) {
                    $gejala_obj["nama_gejala"] = $row_gejala_obj["nama_gejala"];
                    $gejala_obj["keterangan"] = $row_gejala_obj["keterangan"];
                }
            }
            array_push($list_gejala, $gejala_obj);
        }
    }
    return $list_gejala;
}

function getGejalaWithKodeGejala($db, $kode_gejala) {
    $gejala_obj = array();
    $result_gejala_detail = mysqli_query($db,"SELECT * FROM cf_gejala WHERE kode_gejala='$kode_gejala'");
    if (mysqli_num_rows($result_gejala_detail) > 0) {
        while ($row_gejala_obj = mysqli_fetch_array($result_gejala_detail)) {
            $gejala_obj["nama_gejala"] = $row_gejala_obj["nama_gejala"];
            $gejala_obj["keterangan"] = $row_gejala_obj["keterangan"];
        }
    }
    return $gejala_obj;
}

function updateGejala($db, $kode_gejala, $nama_gejala, $keterangan) {
    mysqli_query($db, "UPDATE cf_gejala SET nama_gejala='$nama_gejala', keterangan='$keterangan' WHERE kode_gejala='$kode_gejala'");
    return true;
}

function addRelasi($db, $kode_diagnosa, $kode_gejala, $mb, $md) {
    $result = mysqli_query($db, "SELECT * FROM cf_relasi WHERE kode_diagnosa='$kode_diagnosa' AND kode_gejala='$kode_gejala'");
    if (mysqli_num_rows($result) > 0) {
        return false;
    }
    if ($mb == null or $md == null) {
        return false;
    }
    $result = mysqli_query($db, "INSERT INTO cf_relasi (kode_diagnosa, kode_gejala, mb, md) VALUES ('$kode_diagnosa', '$kode_gejala', '$mb', '$md')");
    return $result;
}

function delRelasi($db, $kode_diagnosa, $kode_gejala) {
    $result = mysqli_query($db, "SELECT * FROM cf_relasi WHERE kode_diagnosa='$kode_diagnosa' AND kode_gejala='$kode_gejala'");
    if (mysqli_num_rows($result) > 0) {
        $result = mysqli_query($db, "DELETE FROM cf_relasi WHERE kode_diagnosa='$kode_diagnosa' AND kode_gejala='$kode_gejala'");
    }
    if ($result != true) {
        return false;
    }
    return true;
}

// -----------RETURN-----------
// [
//      {
//          "kode_diagnosa": "AD3",
//          "nama_diagnosa": "nama",
//          "keterangan": "sdadadfaffg",
//          "gejala": [
//                  {
//                        "kode_gejala": "G1",
//                        "nama_gejala": "nama"
//                  },
//              ]
//      }
// ]
