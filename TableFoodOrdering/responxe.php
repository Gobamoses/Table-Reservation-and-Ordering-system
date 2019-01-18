<?php

abstract class Responxe {

    public $conn;
    public $affectedrows;

    function __construct() {
        $this->conn = $this->DbConecti();
    }

    function DbConecti() {
        $connection = mysqli_connect(servername, username, password, dbname);
        if (!$connection) {
            die(json_encode($this->ResponseText(TRUE, "FAILED TO CONNECT")));
        }
        return $connection;
    }

    function GetMultiRowsData($sql) {
        if (!$this->conn) {
            die(json_encode($this->ResponseText(TRUE, "FAILED TO CONNECT")));
        }

        $query = mysqli_query($this->conn, $sql);
        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($result, $row);
        }
        if (sizeof($result, 0) > 0) {
            return $result;
        } else {
            return NULL;
        }
    }

    function GetMultiRowsDataSize($sql) {
        if (!$this->conn) {
            die(json_encode($this->ResponseText(TRUE, "FAILED TO CONNECT")));
        }

        $query = mysqli_query($this->conn, $sql);
        $result = array();
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($result, $row);
        }
        if (sizeof($result, 0) > 0) {
            return sizeof($result, 0);
        } else {
            return 0;
        }
    }

    function GetRowDataDB($sql) {
        if (!$this->conn) {
            die(json_encode($this->ResponseText(TRUE, "FAILED TO CONNECT")));
        }
        $query = mysqli_query($this->conn, $sql);
        ($row = mysqli_fetch_assoc($query));
        if (sizeof($row, 0) > 0) {
            return $row;
        } else {
            return NULL;
        }
    }

    function ExecSql($sql, $message) {
        $query = mysqli_query($this->conn, $sql);

        $this->affectedrows = mysqli_affected_rows($this->conn);
        if ($query) {
            return $this->ResponseText(FALSE, $message);
        } else {
            return $this->ResponseText(TRUE, "Failed,try again");
        }
    }

    function CheckParamsIfSet($arrayParams) {
        $response = array();
        foreach ($arrayParams as $value) {
            if (!isset(requestmethod["$value"])) {
                array_push($response, $value);
            }
        }

        if (sizeof($response, 0) > 0) {
            return $response;
        }
        return null;
    }

    function SetParamIfNot($param, $value) {
        if (isset(requestmethod["$param"])) {
            return requestmethod["$param"];
        }
        return $value;
    }

    function ResponseText($boolean, $message) {
        $result = array();
        $result["error"] = $boolean;
        $result["message"] = $message;

        return $result;
        //die(json_encode($result));
    }

    function millitime() {
        $microtime = microtime();
        $comps = explode(' ', $microtime);

        // Note: Using a string here to prevent loss of precision
        // in case of "overflow" (PHP converts it to a double)
        return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
    }

    function UploadPic($path) {  //$path ends with {/} eg: disorder/malaria/
        $file_path = $path; //("images/")
        if (!file_exists($file_path)) {
            mkdir($file_path, 0777);
        }
        $file_name = basename($_FILES['uploaded_file']['name']);
        $file_path = $file_path . $file_name;

        if (file_exists($file_path)) {
            $file_name = $this->millitime() . $file_name;
            $file_path = $file_path . $file_name;
        }

        if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
            $result = array();
            $result["uploaded"] = TRUE;
            $result["filename"] = $file_name;
            $result["message"] = "Uploaded";
            return $result;
        } else {
            echo NULL;
        }
    }

    function GetPATH($parentfolder) {
        $arrayParams = ["name"];
        $res = $this->CheckParamsIfSet($arrayParams);
        if ($res != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }

        $name = requestmethod["name"];
        $path = "$parentfolder/$name/";
        return $path;
    }

}
