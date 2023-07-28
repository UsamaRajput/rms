<?php
function insert($db, $table, $arr)
{
    $arr_keys = array_keys($arr);
    $arr_keys = implode("`,`", $arr_keys);
    $arr_data = implode("','", $arr);
    $inser_qry = "INSERT INTO `$table`(`$arr_keys`) VALUES ('".$arr_data."')";
    return mysqli_query($db, $inser_qry);
}

function all_data($db,$table,$where = null,$count = false)
{
   $condition = '';
    if($where!=null){
        $condition = " WHERE $where";
    }
    $qry = "SELECT * FROM $table  $condition ";
    $res = mysqli_query($db,$qry);
    if($count==false){
        return mysqli_fetch_assoc($res);
    }elseif($count==true){
        return $res;
    }
}

function update($db, $table, $arr, $where)
{
    $count = count($arr);
    $i = 0;
    $qry_arr = '';
    foreach ($arr as $key => $value) {
        if (++$i != $count) {
            $qry_arr .= " `$key` = '{$value}' , ";
        } else {
            $qry_arr .= " `$key` = '{$value}' ";
        }
    }
    $update_qry = "UPDATE `$table` SET $qry_arr  WHERE $where";
    return mysqli_query($db, $update_qry);
}

function count_data($db,$table,$where)
{
    $res = all_data($db,$table,$where,true);
    return mysqli_num_rows($res);
}

function qry($db,$qry,$fetch=false)
{
    $qry = mysqli_query($db,$qry);
    if ($fetch==true) {
        return mysqli_fetch_assoc($qry);
    }
    return $qry;
}
?>