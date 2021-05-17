<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/9/2561
 * Time: 10:16
 */

class My_connect
{
    public function db()
    {
        global $g_user;
        global $g_pw;
        global $g_db;
        $server = 'localhost';
        $char = 'utf8';
        $mysqli = new mysqli($server, $g_user, $g_pw, $g_db);
        if (mysqli_connect_error()) {
            die('SQL Error Line' . mysqli_connect_errno() . 'Text ' . mysqli_connect_error());
        }
        mysqli_set_charset($mysqli, $char);
        return $mysqli;
    }

    public function Escape($string)
    {
        return mysqli_real_escape_string($this->db(), $string);
    }

    public function result_array($sql)
    {
        $con = $this->db();
        $data = [];
        $result = $con->query($sql) or die($con->error);
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $data[] = $row;
        };
        return $data;
    }

    public function result_row($sql)
    {
        $con = $this->db();
        $result = $con->query($sql) or die($con->error);
        $data = $result->fetch_array(MYSQLI_ASSOC);
        return $data;
    }
}