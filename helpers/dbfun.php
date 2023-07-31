<?php
function insert($db, $table, $arr)
{
    $arr_keys = array_keys($arr);
    $arr_keys = implode("`,`", $arr_keys);
    $arr_data = implode("','", $arr);
    $inser_qry = "INSERT INTO `$table`(`$arr_keys`) VALUES ('" . $arr_data . "')";
    return mysqli_query($db, $inser_qry);
}

function all_data($db, $table, $where = null, $count = false)
{
    $condition = '';
    if ($where != null) {
        $condition = " WHERE $where";
    }
    $qry = "SELECT * FROM $table  $condition ";
    $res = mysqli_query($db, $qry);
    if ($count == false) {
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    } elseif ($count == true) {
        return mysqli_num_rows($res);
    }
}

function del_data($db, $table, $id)
{
    $del_qry = "DELETE FROM {$table} WHERE id = {$id}";
    return mysqli_query($db, $del_qry);
}

function del_custom($db, $table, $condition)
{
    $del_qry = "DELETE FROM {$table} WHERE {$condition}";
    return mysqli_query($db, $del_qry);
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

function single_data($db, $table, $where = null)
{
    $condition = '';
    if ($where != null) {
        $condition = " WHERE $where";
    }
    $qry = "SELECT * FROM $table  $condition ";
    $res = mysqli_query($db, $qry);
    return mysqli_fetch_assoc($res);
}

function qry($db, $qry, $fetch = false, $all = false)
{
    $qry = mysqli_query($db, $qry);
    if ($fetch == true) {
        if ($all !== false) {
            return mysqli_fetch_all($qry, MYSQLI_ASSOC);
        } else {
            return mysqli_fetch_assoc($qry);
        }
    }
    return $qry;
}
