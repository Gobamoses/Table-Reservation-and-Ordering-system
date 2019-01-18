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

define("addorder", "addorder");
define("getorders", "getorders");
define("getallorders", "getallorders");
define("updatepayment", "updatepayment");
define("GetOrderDetails", "GetOrderDetails");
class Orders extends Responxe {

    function Init() {
        if (isset(requestmethod["action"])) {
            switch (requestmethod["action"]) {

case GetOrderDetails:{
    die(json_encode($this->GetOrderDetails()));
    break;
}

case updatepayment: {
                        die(json_encode($this->UpdatePayment()));
                        break;
                    }
                case addorder: {
                        die(json_encode($this->AddOrder()));
                        break;
                    }

                case getorders: {
                        die(json_encode($this->GetOrders()));
                        break;
                    }

                case getallorders: {
                        die(json_encode($this->GetAllOrders()));
                        break;
                    }
                default:
                    break;
            }
        } else {
            die(json_encode($this->ResponseText(TRUE, "Action Undefined")));
        }
    }

    function AddOrder() {
        $arrayParams = ["tbl_id", "transactioncode", "totalamount", "items"];

        $res = $this->CheckParamsIfSet($arrayParams);

        if ($res != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }

        $tbl_id = requestmethod["tbl_id"];
        $transactioncode = requestmethod["transactioncode"];
        $totalamount = requestmethod["totalamount"];
        $items = requestmethod["items"];
        $itemsids = explode(";", $items);

        if (!is_array($itemsids)) {
            die(json_encode($this->ResponseText(true, "Data parsing failed")));
        }

        $sql = "INSERT INTO tbbooked(tbl_id,transactioncode,totalamount) VALUES('$tbl_id','$transactioncode','$totalamount')";
        $this->ExecSql($sql, "Order Inserted");
        if (($this->affectedrows) > 0) {
            foreach ($itemsids as $value) {
                $this->AddBookedItems($value, $transactioncode);
            }
            return $this->ResponseText(FALSE, "Order successfully placed");
        } else {
            return $this->ResponseText(TRUE, "Failed, try again");
        }
    }

    function AddBookedItems($itemid, $trcode) {
        $sql = "INSERT INTO bokeditems(itemid,bi_transactioncode) VALUES('$itemid','$trcode')";
        $this->ExecSql($sql, "done");
    }

    function GetAllOrders() {
        $sql = "SELECT * FROM tbbooked WHERE servingstatus='0'";
        $res = $this->GetMultiRowsData($sql);
        if ($res != NULL) {
            return $res;
        } else {
            return $this->ResponseText(TRUE, "No orders made");
        }
    }

    function GetOrders() {
        $arrayParams = ["transactioncode"];
        $resa = $this->CheckParamsIfSet($arrayParams);
        if ($resa != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }
        $trcode = requestmethod["transactioncode"];
        $sql = "SELECT * FROM tbbooked,bokeditems,foods WHERE bokeditems.`bi_transactioncode`= tbbooked.`transactioncode` AND foods.`fd_id`= bokeditems.`itemid` AND tbbooked.`transactioncode`='$trcode'";
        $res = $this->GetMultiRowsData($sql);
        if ($res != NULL) {
            return $res;
        } else {
            return $this->ResponseText(TRUE, "No orders made");
        }
    }

    function GetOrderDetails(){
        $arrayParams = ["transactioncode"];
        $resa = $this->CheckParamsIfSet($arrayParams);
        if ($resa != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }

$trcode=requestmethod["transactioncode"];
$sql="select * from bokeditems,foods where foods.fd_id=bokeditems.itemid AND bokeditems.bi_transactioncode='$trcode'";
  $res = $this->GetMultiRowsData($sql);
        if ($res != NULL) {
            return $res;
        } else {
            return $this->ResponseText(TRUE, "No orders made");
        }

    }

function UpdatePayment(){
     $arrayParams = ["transactioncode"];
        $resa = $this->CheckParamsIfSet($arrayParams);
        if ($resa != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }
        $trcode = requestmethod["transactioncode"];
        $sql="UPDATE tbbooked SET paymentstatus='PAYED' WHERE transactioncode='$trcode'";

       $rsd= $this->ExecSql($sql, "Order Inserted");
       if ($rsd!=NULL) {
           $this->IncrementOrder($trcode);
           return $this->ResponseText(FALSE, "Payment made. Thanks");
       }else{
          return $this->ResponseText(TRUE, "Failed, try again");
       }
    }

    function IncrementOrder($trcode){
        $sql="select DISTINCTROW(tbltables.tbl_numusers),tbltables.`tbl_id` from tbbooked,tbltables where tbltables.tbl_id=tbbooked.tbl_id and tbbooked.transactioncode='$trcode'";

$res= $this->ExecSql($sql, "Order Inserted");
  if ($res["tbl_numusers"]!='') {
    $t_0=$res["tbl_numusers"]+1;
    $tbl_id=$res["tbl_id"];
      $sql="UPDATE tbltables SET tbl_numusers='$t_0' WHERE tbl_id='$tbl_id'";
      $this->ExecSql($sql, "successfully");
  }

    }
}
