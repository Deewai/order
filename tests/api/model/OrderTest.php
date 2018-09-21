<?php
use PHPUnit\Framework\TestCase;
use App\model\Order;
class OrderTest extends TestCase
{
    private $order;

    public function setUp(){
        $this->order = new Order();
        $this->order->get_conn()->beginTransaction();
    }

    public function tearDown(){
        $this->order->get_conn()->rollback();
        $this->order = null;
    }

    public function testCreate(){
        $response = $this->order->create(50);
        $this->assertArrayHasKey('id',$response);
        $this->assertArrayHasKey('distance',$response);
        $this->assertArrayHasKey('status',$response);
        $this->assertEquals(50,$response['distance']);
        
    }

    public function testUpdate(){
        $response = $this->order->create(50);
        $result = $this->order->update($response['id']);
        $this->assertArrayHasKey('status',$result);
        $this->assertEquals('SUCCESS',$result['status']);
        $result = $this->order->update($response['id']);
        $this->assertArrayHasKey('error',$result);
        $this->assertEquals('ORDER_ALREADY_BEEN_TAKEN',$result['error']);
        $result = $this->order->update('me');
        $this->assertArrayHasKey('error',$result);
        $this->assertEquals('ERROR_WHILE_TAKING_ORDER',$result['error']);
    }

    public function testCount(){
        $response = $this->order->create(50);
        $result = $this->order->update($response['id']);
        $this->assertArrayHasKey('status',$result);
        $this->assertEquals('SUCCESS',$result['status']);
    }
}
