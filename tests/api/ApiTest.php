<?php
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
/**
 * Class RecipeTest
 */
class ApiTest extends TestCase
{
    private $user;
    private $recipe;


    /**
     * This is set up method for setting the primary need to tests
     */
    protected function setUp()
    {
        // ifconfig result provide this IP address
        $this->client = new GuzzleHttp\Client([
            'base_uri' => '172.17.0.4:80',
            'headers' => [
                'Accept' => 'application/json; charset=utf-8',
                'X-Auth-Token' => '12345678',
                'X-Auth-Secret' => '12345678'
            ]
        ]);

    }

    /**
     * type of desctructor
     */
    protected function tearDown()
    {
    }

    /**
     * test user login which is require to call any protected api
     */
    public function testLoginPost()
    {
        $response = $this->client->request('POST', '/order',
            [
                'form_params' => [
                    'origin' => ['1001','4551'],
                    'destination' => ['2011','8654']
                ]
            ]
        );
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody(), true);
        var_dump($body);
    }

    /**
     * test recipes api
     */
    // public function testRecipes()
    // {
    //     $response = $this->client->request('GET', '/api/recipes');
    //     $this->assertEquals(200, $response->getStatusCode());
    //     $body = json_decode($response->getBody(), true);
    //     $this->assertEquals('Recipes fetched successfully', $body['message']);
    // }

    // /**
    //  * this will test to fetch one recipe
    //  */
    // public function testRecipe()
    // {
    //     $response = $this->client->request('GET', '/api/recipes/1');
    //     $this->assertEquals(200, $response->getStatusCode());
    //     $body = json_decode($response->getBody(), true);
    //     $this->assertEquals('Recipe fetched successfully', $body['message']);
    // }

    // /**
    //  * this will test create new recipe
    //  */
    // public function testRecipePost()
    // {
    //     $response = $this->client->request('POST', '/api/recipes',
    //         [
    //             'json' => [
    //                 "recipe_name" => $this->randw(8),
    //                 "preparation_time" => 2,
    //                 "difficulty_level" => "2",
    //                 "veg" => true,
    //                 "status" => true
    //             ]
    //         ]
    //     );
    //     $this->assertEquals(200, $response->getStatusCode());
    //     $body = json_decode($response->getBody(), true);
    //     $this->assertEquals('Recipe created successfully', $body['message']);
    // }

    // /**
    //  * this will test recipe update
    //  */
    // public function testRecipeUpdate()
    // {
    //     $response = $this->client->request('PATCH', '/api/recipes/1',
    //         [
    //             'json' => [
    //                 "recipe_name" => $this->randw(8),
    //                 "preparation_time" => 3,
    //                 "difficulty_level" => "3",
    //                 "veg" => false,
    //                 "status" => true
    //             ]
    //         ]
    //     );
    //     $this->assertEquals(200, $response->getStatusCode());
    //     $body = json_decode($response->getBody(), true);
    //     $this->assertEquals('Recipe updated successfully', $body['message']);
    // }

    // /**
    //  * this will test search by keyword
    //  */
    // public function testSearchPost()
    // {
    //     $response = $this->client->request('POST', '/api/recipes/search/biri');
    //     $this->assertEquals(200, $response->getStatusCode());
    //     $body = json_decode($response->getBody(), true);
    //     $this->assertEquals('Recipe found successfully', $body['message']);
    // }

}