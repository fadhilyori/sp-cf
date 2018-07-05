<?php
$gejala = $_POST['gejala'];
$gejala = split(',', $gejala);
$gejala_temp = $gejala;

$rows = $db->get_results("SELECT * FROM cf_gejala WHERE kode_gejala IN ('".implode("','", $gejala)."')");
$rows = $db->get_results("SELECT * 
    FROM cf_relasi r INNER JOIN cf_diagnosa d ON d.kode_diagnosa = r.kode_diagnosa      
    WHERE r.kode_gejala IN ('".implode("','", $gejala)."') ORDER BY r.kode_diagnosa, r.kode_gejala");

foreach($rows as $row){
    $diagnosa[$row->kode_diagnosa][mb] = $diagnosa[$row->kode_diagnosa][mb] + $row->mb * (1 - $diagnosa[$row->kode_diagnosa][mb]);
    $diagnosa[$row->kode_diagnosa][md] = $diagnosa[$row->kode_diagnosa][md] + $row->md * (1 - $diagnosa[$row->kode_diagnosa][md]);

    $diagnosa[$row->kode_diagnosa][cf] = $diagnosa[$row->kode_diagnosa][mb] -  $diagnosa[$row->kode_diagnosa][md];

    $diagnosa[$row->kode_diagnosa][nama_diagnosa] = $row->nama_diagnosa;
    $diagnosa[$row->kode_diagnosa][solusi] = $row->keterangan;
}
$no=1;
        function ranking($array){
            $new_arr = array();
            foreach($array as $key => $value) {
                $new_arr[$key] = $value[cf];
            }
            arsort($new_arr);

            $result = array();
            foreach($new_arr as $key => $value){
                $result[$key] = ++$no;
            }
            return $result;
        }

        $rank = ranking($diagnosa);

        $list = array();
        foreach($rank as $key => $value) {
            $hasil = array();
            $hasil['nama_diagnosa'] = $diagnosa[$key][nama_diagnosa];
            $hasil['kepercayaan'] = $diagnosa[$key][cf];
            $hasil['solusi'] = $diagnosa[$key][solusi];
            array_push($list, $hasil);
        }
        reset($rank);
        $_SESSION[gejala] = $gejala;