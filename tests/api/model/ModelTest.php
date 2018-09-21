<?php
use PHPUnit\Framework\TestCase;
use App\model\Model;
class ModelTest extends TestCase
{

    public function testConnection(){
        $model = new Model();
        $this->assertInstanceOf(\PDO::class,$model->get_conn());
    }
}
