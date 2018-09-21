<?php
// namespace tests\model;
use PHPUnit\Framework\TestCase;
// use GuzzleHttp\Psr7\Request;
// use Psr\Http\Message\ResponseInterface;
use App\controller\OrderController;
use App\model\Model;
class OrderControllerTest extends TestCase
{
    private $order; private $model;

    public function setUp(){
        $this->order = new OrderController();
        $this->model = $this->order->get_model();
        $this->model->get_conn()->beginTransaction();
    }

    public function tearDown(){
        $this->model->get_conn()->rollback();
        $this->order = $this->model = null;
    }

    public function testOrderModel(){
        $this->assertInstanceOf(\App\model\Model::class,$this->order->get_model());
    }

    public function testCreateOrder(){
        $response = $this->order->createOrder(['10','15'],['20','11']);
        $this->assertArrayHasKey('id',$response);
        $this->assertArrayHasKey('distance',$response);
        $this->assertArrayHasKey('status',$response);
        
    }

    public function testTakeOrder(){
        $response = $this->order->createOrder(['10','15'],['20','11']);
        $result = $this->order->takeOrder($response['id'],'taken');
        $this->assertArrayHasKey('status',$result);
        $this->assertEquals('SUCCESS',$result['status']);
        $result = $this->order->takeOrder($response['id'],'');
        $this->assertArrayHasKey('error',$result);
        $this->assertEquals('INVALID_ORDER_STATUS',$result['error']);
        $result = $this->order->takeOrder('3000ff','taken');
        $this->assertArrayHasKey('error',$result);
        $this->assertEquals('ORDER_DOES_NOT_EXIST',$result['error']);
        $result = $this->order->takeOrder(3000,'taken');
        $this->assertArrayHasKey('error',$result);
        $this->assertEquals('ORDER_DOES_NOT_EXIST',$result['error']);
    }

    public function testOrderList(){
        $response = $this->order->createOrder(['10','15'],['20','11']);
        $result = $this->order->orderList(1,5);
        $this->assertTrue(is_array($result));
    }
}
