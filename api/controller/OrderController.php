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
        $api = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$origin[0] . "," . $origin[1]."&destinations=".$destination[0] . "," . $destination[1]."&key=".api_key);
            $data = json_decode($api);
        $distance = $data->rows[0]->elements[0]->distance->value;
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