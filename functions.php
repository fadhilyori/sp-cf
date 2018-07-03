<?php
include 'config.php';

function CF_get_diagnosa_option($selected = ''){
    global $db;
    $rows = $db->get_results("SELECT kode_diagnosa, nama_diagnosa FROM cf_diagnosa ORDER BY kode_diagnosa");
    foreach($rows as $row){
        if($row->kode_diagnosa==$selected)
            $a.="<option value='$row->kode_diagnosa' selected>[$row->kode_diagnosa] $row->nama_diagnosa</option>";
        else
            $a.="<option value='$row->kode_diagnosa'>[$row->kode_diagnosa] $row->nama_diagnosa</option>";
    }
    return $a;
}

function CF_get_gejala_option($selected = ''){
    global $db;
    $rows = $db->get_results("SELECT kode_gejala, nama_gejala FROM cf_gejala ORDER BY kode_gejala");
    foreach($rows as $row){
        if($row->kode_gejala==$selected)
            $a.="<option value='$row->kode_gejala' selected>[$row->kode_gejala] $row->nama_gejala</option>";
        else
            $a.="<option value='$row->kode_gejala'>[$row->kode_gejala] $row->nama_gejala</option>";
    }
    return $a;
}

/**
$NILAI = array(
    1 => 'Sangat Rendah',
    2 => 'Rendah',
    3 => 'Cukup',
    4 => 'Tinggi',
    5 => 'Sangat Tinggi'
);

$rows = $db->get_results("SELECT kode_dg, nama_dg FROM cf_diagnosa ORDER BY kode_dg");
foreach($rows as $row){
    $DIAGNOSA[$row->kode_dg] = $row->nama_dg;
}

$rows = $db->get_results("SELECT kode_kriteria, nama_kriteria, atribut, bobot FROM cf_kriteria ORDER BY kode_kriteria");
foreach($rows as $row){
    $KRITERIA[$row->kode_kriteria] = array(
        'nama_kriteria'=>$row->nama_kriteria,
        'atribut'=>$row->atribut,
        'bobot'=>$row->bobot
    );
}

function get_rank($array){
    $data = $array;
    arsort($data);
    $no=1;
    $new = array();
    foreach($data as $key => $value){
        $new[$key] = $no++;
    }
    return $new;
}

function TOPSIS_get_hasil_analisa(){
    global $db;
    $rows = $db->get_results("SELECT a.kode_diagnosa, k.kode_kriteria, ra.nilai
        FROM cf_diagnosa a 
        	INNER JOIN cf_rel_diagnosa ra ON ra.kode_diagnosa=a.kode_diagnosa
        	INNER JOIN cf_kriteria k ON k.kode_kriteria=ra.kode_kriteria
        ORDER BY a.kode_diagnosa, k.kode_kriteria");
    $data = array();
    foreach($rows as $row){
        $data[$row->kode_diagnosa][$row->kode_kriteria] = $row->nilai;
    }
    return $data;
}

function TOPSIS_hasil_analisa($echo=true){
    global $db, $ALTERNATIF, $KRITERIA;
    
    
    $data = TOPSIS_get_hasil_analisa();
    
    if(!$echo)
        return $data;
        
    $r.= "<tr><th></th>";   	
    $no=1;	
    foreach($data[key($data)] as $key => $value){
        $r.= "<th>".$KRITERIA[$key][nama_kriteria]."</th>";
        $no++;      
    }    
    
    $no=1;	
    foreach($data as $key => $value){
        $r.= "<tr>";
        $r.= "<th>".$ALTERNATIF[$key]."</th>";
        foreach($value as $k => $v){
            $r.= "<td>".$v."</td>";
        }        
        $r.= "</tr>";
        $no++;    
    }    
    $r.= "</tr>";
    return $r;
}

function TOPSIS_nomalize($array, $max = true){
    $data = array();
    $kuadrat = array();
            
    foreach($array as $key => $value){     
        foreach($value as $k => $v){
            $kuadrat[$k]+= ($v * $v);           
        }                
    }    
    
    foreach($array as $key => $value){                
        foreach($value as $k => $v){
            $data[$key][$k] = $v / sqrt($kuadrat[$k]);
        }
    }
    return $data;
}

function TOPSIS_nomal_terbobot($array){
    global $KRITERIA;
    $data = array();
    
    foreach($array as $key => $value){                
        foreach($value as $k => $v){
            $data[$key][$k] = $v * $KRITERIA[$k]['bobot'];
        }
    }    
    
    return $data;
}

function TOPSIS_solusi_ideal($array){
    global $KRITERIA;
    $data = array();
    
    $temp = array();
    
    foreach($array as $key => $value){                
        foreach($value as $k => $v){
            $temp[$k][] = $v;
        }
    }    
    
    foreach($temp as $key => $value) {
        $max = max ($value);
        $min = min ($value);
        if($KRITERIA[$key][atribut]=='benefit')
        {
            $data[positif][$key] = $max;
            $data[negatif][$key] = $min;
        }            
        else
        {
            $data[positif][$key] = $min;
            $data[negatif][$key] = $max;            
        }
    }
    
    return $data;
}

function TOPSIS_jarak_solusi($array, $ideal){    
    $temp = array();
    
    foreach($array as $key => $value){                
        foreach($value as $k => $v){
            $temp[$key][positif]+= ($v - $ideal[positif][$k]) * ($v - $ideal[positif][$k]);
            $temp[$key][negatif]+= ($v - $ideal[negatif][$k]) * ($v - $ideal[negatif][$k]);
        }
        $temp[$key][positif] = sqrt($temp[$key][positif]);
        $temp[$key][negatif] = sqrt($temp[$key][negatif]);
    }    
        
    return $temp;
}

function TOPSIS_preferensi($array){
    global $KRITERIA;
    
    $temp = array();
    
    foreach($array as $key => $value){                
        $temp[$key] = $value[negatif] / ($value[positif] + $value[negatif]);
    }    
        
    return $temp;
}

function get_atribut_option($selected = ''){
    $atribut = array('benefit'=>'Benefit', 'cost'=>'Cost');   
    foreach($atribut as $key => $value){
        if($selected==$key)
            $a.="<option value='$key' selected>$value</option>";
        else
            $a.= "<option value='$key'>$value</option>";
    }
    return $a;
}*/