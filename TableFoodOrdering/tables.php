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
define("gettables", "gettables");
define("getALLtables", "getALLtables");
define("addtable", "addtable");
define("resettb", "resettb");
class Tables extends Responxe {

    function Init() {
        if (isset(requestmethod["action"])) {
            switch (requestmethod["action"]) {
                case gettables: {
                        die(json_encode($this->GetTables()));
                        break;
                    }
                       case getALLtables: {
                        die(json_encode($this->GetAllTables()));
                        break;
                    }
                    case addtable: {
                        die(json_encode($this->AddTable()));
                        break;
                    }
                    case resettb: {
                        die(json_encode($this->ResetTbNumUsers()));
                        break;
                    }
                default : {
                        die(json_encode($this->ResponseText(TRUE, "")));
                    }
            }
        }
    }

    function GetTables() {
        $sql = "SELECT * FROM tbltables WHERE tbl_numusers!=tbl_totalnumusers";
        $res = $this->GetMultiRowsData($sql);
        if ($res != NULL) {
            return $res;
        } else {
            return $this->ResponseText(TRUE, "NO TABLES AVAILABLE");
        }
    }

  function  GetAllTables(){
$sql = "SELECT * FROM tbltables";
        $res = $this->GetMultiRowsData($sql);
        if ($res != NULL) {
            return $res;
        } else {
            return $this->ResponseText(TRUE, "NO TABLES AVAILABLE");
        }
    }

function AddTable(){
    $arrayParams = ["tablename","seats"];

        $res = $this->CheckParamsIfSet($arrayParams);

        if ($res != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }


        $tbname=requestmethod["tablename"];
         $seats=requestmethod["seats"];
         
        $sql="INSERT INTO tbltables (tbl_name,tbl_totalnumusers) VALUES('$tbname','$seats')";
        $rs = $this->ExecSql($sql, "Successfull");
        if (($this->affectedrows) > 0) {
            return $rs;
        } else {
            return $this->ResponseText(TRUE, "Failed, try again");
        }

}

function ResetTbNumUsers(){
	$arrayParams = ["tableid"];

        $res = $this->CheckParamsIfSet($arrayParams);

        if ($res != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }

        $id=requestmethod["tableid"];
        $sql="UPDATE tbltables SET tbl_numusers='0' WHERE tbl_id='$id'";
        $rs = $this->ExecSql($sql, "Successfull");
        if (($this->affectedrows) > 0) {
            return $rs;
        } else {
            return $this->ResponseText(TRUE, "Failed, try again");
        }
}

}
