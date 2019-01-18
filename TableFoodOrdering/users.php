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
define("login", "login");
define("register", "register");
define("all", "all");
define("romove", "romove");

class Users extends Responxe {

    function Init() {

        if (isset(requestmethod["action"])) {
            switch (requestmethod["action"]) {
                case register: {
                        die(json_encode($this->Register()));
                        break;
                    }
                case login: {
                        die(json_encode($this->Login()));
                        break;
                    }
                case all: {
                        die(json_encode($this->GetUsers()));
                        break;
                    }
                case romove: {
                        die(json_encode($this->RemoveUser()));
                        break;
                    }
                default:
                    break;
            }
        } else {
            die(json_encode($this->ResponseText(TRUE, "Action Undefined")));
        }
    }

    function Login() {
        $arrayParams = ["phone", "password"];

        $res = $this->CheckParamsIfSet($arrayParams);

        if ($res != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }

        $phone = requestmethod["phone"];
        $password = requestmethod["password"];
        $sql = "SELECT * FROM `users` WHERE user_phone='$phone' AND user_password='$password'";

        $result = $this->GetRowDataDB($sql);
        if ($result != NULL && $result["user_name"] != '') {
            return $result;
        } else {
            return $this->ResponseText(TRUE, "User not found");
        }
    }

    function Register() {
        $arrayParams = ["name", "phone", "password"];

        $res = $this->CheckParamsIfSet($arrayParams);

        if ($res != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }

        $name = requestmethod["name"];
        $phone = requestmethod["phone"];
        $password = requestmethod["password"];
        $email = $this->SetParamIfNot("email", "");

        $salt = md5($password);
        $sql = "INSERT INTO users(user_name,user_phone,user_email,user_password,user_passwordsalt) VALUES('$name','$phone','$email','$password','$salt')";
        $rs = $this->ExecSql($sql, "Registration Successfull");
        if (($this->affectedrows) > 0) {
            return $rs;
        } else {
            return $this->ResponseText(TRUE, "Failed, try again");
        }
    }

    function GetUsers() {
        $sql = "SELECT * FROM users ORDER BY user_id DESC LIMIT 200";
        $res = $this->GetMultiRowsData($sql);
        if ($res != NULL) {
            return $res;
        } else {
            return $this->ResponseText(TRUE, "NO Users");
        }
    }

    function RemoveUser() {
        $arrayParams = ["phone"];

        $res = $this->CheckParamsIfSet($arrayParams);

        if ($res != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }
        $phone = requestmethod["phone"];
        $sql = "DELETE FROM users WHERE user_phone='$phone'";

        $result = $this->ExecSql($sql, "Operation Successfull");
        return $result;
    }

    function GetSearchUsers() {
        $arrayParams = ["phone"];

        $res = $this->CheckParamsIfSet($arrayParams);

        if ($res != null) {
            die(json_encode($this->ResponseText(true, "Cant process incomplete form data")));
        }
        $phone = requestmethod["phone"];
        $sql = "SELECT * FROM users WHERE user_phone LIKE='%$phone%' ORDER BY user_id DESC LIMIT 200";
        $result = $this->GetMultiRowsData($sql);
        if ($result != NULL) {
            return $result;
        } else {
            return $this->ResponseText(TRUE, "NO Users");
        }
    }

}
