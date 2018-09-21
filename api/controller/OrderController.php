<?php
namespace App\controller;

use App\model\Order;
class OrderController{
    private $model;
    public function __construct(){
        $this->model = new Order();
    }

    public function get_model(){
        return $this->model;
    }

    public function createOrder(array $origin,array $destination){
        $api = @file_get_contents("https://route.api.here.com/routing/7.2/calculateroute.json?app_id=".app_id."&app_code=".app_code."&waypoint0=geo!".$origin[0] . "," . $origin[1]."&waypoint1=geo!".$destination[0] . "," . $destination[1]."&mode=fastest;car;traffic:disabled");
        $data = json_decode($api);

        if(!isset($data->response->route)){
            return ['error' => 'ERROR_GETTING_DISTANCE'];
        }
        $distance = $data->response->route[0]->summary->distance;
        return $this->model->create($distance);
    }

    public function takeOrder($id,$status){
        if(!is_numeric($id)){
            return ['error'=>'ORDER_DOES_NOT_EXIST'];
        }
        if($status != 'taken'){
            return ['error'=>'INVALID_ORDER_STATUS'];
        }
        return $this->model->update($id,$status);
    }

    public function orderList($page,$limit){
        $total = $this->model->count();
        $offset = ($page - 1) * $limit;
        return $this->model->get($offset,$limit);
    }
}