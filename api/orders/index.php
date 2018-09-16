<?php
/**
 * Created by PhpStorm.
 * User: kcavi
 * Date: 16.09.2018
 * Time: 21:31
 */

include_once '../../autoload.php';
header("Content-Type: application/json; charset=UTF-8");

// Get method
$method = isset($_GET['method']) ? $_GET['method'] : '';

// Create new Orders instance
$orders = new \Classes\Orders();

switch($method) {
    /**
     * Take (update) the order
     */
    case 'take':
        // Allow only PUT method
        header("Access-Control-Allow-Methods: PUT");
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $result = $orders->take($id);

        echo $result;
        break;

    /**
     * Get list of orders
     */
    case 'list':
        // Allow only GET method
        header("Access-Control-Allow-Methods: GET");

        $results = $orders->records();
        echo $results;

        break;

    /**
     * Create new order
     */
    default:
        // Allow only POST method
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        if(count($_POST) == 0) { // if you don't have html form for sending data
            $_POST = [
                'origin' => [41.43206, -81.38992],
                'destination' => [43.43206, -81.38992],
            ];
        }

        $result = $orders->create($_POST);
        echo $result;
}