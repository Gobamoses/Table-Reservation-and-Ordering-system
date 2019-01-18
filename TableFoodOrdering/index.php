<?php

require_once './config.php';
require_once './responxe.php';
require_once './users.php';
require_once './tables.php';
require_once './menu.php';
require_once './orders.php';
define("users", "users");
define("tables", "tables");
define("menu", "menu");
define("orders", "orders");

if (isset(requestmethod["target"])) {

    switch (requestmethod["target"]) {
        case users: {
                (new Users())->Init();
                break;
            }
        case tables: {
                (new Tables())->Init();
                break;
            }
        case menu: {
                (new Menu())->Init();
                break;
            }

        case orders: {
                (new Orders())->Init();
                break;
            }

        default : {
                $result = array();
                $result["error"] = TRUE;
                $result["message"] = "Unknown Target";
                die(json_encode($result));
            }
    }
} else {
    $result = array();
    $result["error"] = TRUE;
    $result["message"] = "Unknown Target";
    die(json_encode($result));
}
?>