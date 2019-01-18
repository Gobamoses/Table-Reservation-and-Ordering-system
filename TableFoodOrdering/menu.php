<?php

/*
 * Copyright (C) 2018 Aviator
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
define("getfoods", "getfoods");
define("getallfoods", "getallfoods");
define("remove", "remove");
define("update", "update");
define("add", "add");
define("getbeverages", "getbeverages");

class Menu extends Responxe {

    function Init() {
        if (isset(requestmethod["action"])) {
            switch (requestmethod["action"]) {
                case getfoods:
                    die(json_encode($this->GetFoods()));
                    break;

                case getbeverages:
                    die(json_encode($this->GetBeverages()));
                    break;
                case getallfoods:
                    die(json_encode($this->GetAllFoods()));
                    break;
                case remove:
                    die(json_encode($this->RemoveFood()));
                    break;
                case add:
                    die(json_encode($this->AddFood()));
                    break;
                case update:
                    die(json_encode($this->UpdateFood()));
                    break;

                default : {
                        die(json_encode($this->ResponseText(TRUE, "")));
                    }
            }
        }
    }

    function GetFoods() {
        $sql = "SELECT * FROM foods WHERE fd_type='FOOD' AND fd_status='0'"; //AVAILABLE ONLY
        $res = $this->GetMultiRowsData($sql);

        if ($res != NULL) {
            return $res;
        } else {
            return $this->ResponseText(TRUE, "NO FOODS AVAILABLE");
        }
    }

    function GetBeverages() {
        $sql = "SELECT * FROM foods WHERE fd_type LIKE '%BEVERAGE%' AND fd_status='0'"; //AVAILABLE ONLY
        $res = $this->GetMultiRowsData($sql);

        if ($res != NULL) {
            return $res;
        } else {
            return $this->ResponseText(TRUE, "NO FOODS AVAILABLE");
        }
    }

    function GetAllFoods() {
        $sql = "SELECT * FROM foods ORDER BY fd_id DESC LIMIT 200";
        $res = $this->GetMultiRowsData($sql);
        if ($res != NULL) {
            return $res;
        } else {
            return $this->ResponseText(TRUE, "NO Users");
        }
    }

    function RemoveFood() {
        $arrayParams = ["id"];

        $res = $this->CheckParamsIfSet($arrayParams);

        if ($res != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }
        $id = requestmethod["id"];
        $sql = "DELETE FROM foods WHERE fd_id='$id'";

        $result = $this->ExecSql($sql, "Operation Successfull");
        return $result;
    }

    function UpdateFood() {
        $arrayParams = ["id", "name", "type", "price", "availability"];
        $res = $this->CheckParamsIfSet($arrayParams);

        if ($res != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }

        $id = requestmethod["id"];
        $name = requestmethod["name"];
        $type = requestmethod["type"];
        $price = requestmethod["price"];
        $availability = $this->SetParamIfNot("availability", '0');

        $sql = "UPDATE foods SET fd_name='$name',fd_type='$type',fd_price='$price',fd_status='$availability' WHERE fd_id='$id'";
        $rs = $this->ExecSql($sql, "Operation Successfull");
        if (($this->affectedrows) > 0) {
            return $rs;
        } else {
            return $this->ResponseText(TRUE, "Failed, try again");
        }
    }

    function AddFood() {
        $arrayParams = ["name", "type", "price"];
        $res = $this->CheckParamsIfSet($arrayParams);

        if ($res != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }

        $name = requestmethod["name"];
        $type = requestmethod["type"];
        $price = requestmethod["price"];
        $availability = $this->SetParamIfNot("availability", '0');

        $sql = "INSERT INTO foods(fd_name,fd_type,fd_price,fd_status) VALUES('$name','$type','$price','$availability')";
        $rs = $this->ExecSql($sql, "Operation Successfull");
        if (($this->affectedrows) > 0) {
            return $rs;
        } else {
            return $this->ResponseText(TRUE, "Failed, try again");
        }
    }

}
