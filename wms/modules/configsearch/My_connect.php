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

    public function insert($table, $data)
    {
        $connect = $this->db();
        $fields = "";
        $values = "";
        $i = 1;
        foreach ($data as $key => $val) {
            if ($i != 1) {
                $fields .= ", ";
                $values .= ", ";
            }
            $fields .= "{$key}";
            $values .= "'{$val}'";
            $i++;
        }
        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$values})";
        if ($connect->query($sql)) {
            return true;
        } else {
            die("SQL Error: <br>" . $sql . "<br>" . $connect->error);
        }
    }

    public function update($table, $id, $fields)
    {
        $connect = $this->db();
        $set = '';
        $x = 1;
        foreach ($fields as $name => $value) {
            $set .= "{$name} = \"{$value}\"";
            if ($x < count($fields)) {
                $set .= ',';
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE {$id}";
        if ($connect->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($table, $id)
    {
        $connect = $this->db();
        $sql = "DELETE FROM {$table} WHERE {$id}";
        if ($connect->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
}