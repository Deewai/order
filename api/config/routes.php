<?php
/**
 * this script will process all routing eg. http://localhost/orders [get/post/put]
 * along with headers for authentication see the details in readme
 */

require (__DIR__ . '/config.php');

// Grabs the URI and breaks it apart

$requestUri = str_replace($_SERVER['HTTP_HOST'], '', $_SERVER['REQUEST_URI']);

// Route it up by catching uri as well as headers and input values
switch ($requestUri) {
    case '/order':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['origin']) && is_array(json_decode($_POST['origin']))){
                $origin = json_decode($_POST['origin']);
            }
            else{
                header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
                echo json_encode(['error' => 'BAD_REQUEST']);
                die();
            }
            if(isset($_POST['destination']) && is_array(json_decode($_POST['destination']))){
                $destination = json_decode($_POST['destination']);
            }
            else{
                header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
                echo json_encode(['error' => 'BAD_REQUEST']);
                die();
            }
            $response = (new App\controller\OrderController())->createOrder($origin,$destination);
            if(!isset($response['error'])){
                header('HTTP/1.1 200 OK');        
            }
            else{
                header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            }
            echo json_encode($response);
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);

            echo json_encode(['error' => 'BAD_REQUEST']);
        }
        break;
    // take an order /api/order/:id
    case (preg_match('/\/order\/\d+$/', $requestUri, $matches) ? true : false):
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $matches = explode('/',$matches[0]);
            $id = $matches[count($matches) - 1];
            parse_str(file_get_contents("php://input"),$putData);
            if(!isset($putData['status'])){
                echo json_encode(['status' => '500', 'message' => 'Bad request']);
            }
            $status = $putData['status'];
            $response = (new App\controller\OrderController())->takeOrder($id,$status);
            if(!isset($response['error'])){
                header('HTTP/1.1 200 OK');        
            }
            else if($response['error'] === 'ORDER_ALREADY_BEEN_TAKEN'){
                header($_SERVER['SERVER_PROTOCOL'] . '', true, 409);
            }
            else{
                header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            }
            echo json_encode($response);
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);

            echo json_encode(['error' => 'BAD_REQUEST']);
        }
        break;
    // api/orders?page=:page&limit=:limit
    case ((preg_match('/\/orders\?page\=\d+\&limit\=\d+$/', $requestUri, $matches) || preg_match('/\/orders/', $requestUri, $matches)) ? true : false):
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
            $response = (new App\controller\OrderController())->orderList($page,$limit);
            if(!isset($response['error'])){
                header('HTTP/1.1 200 OK');        
            }
            else{
                header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            }
            echo json_encode($response,true);
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);

            echo json_encode(['error' => 'BAD_REQUEST']);
        }

        break;
    //Everything else
    default:
        echo json_encode(['status' => '404', 'error' => 'NOT_FOUND']);
        break;
}
