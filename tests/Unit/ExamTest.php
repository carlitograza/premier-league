<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \CGraza\DataImporter;
use App\Model\PlayerModel;
use Illuminate\Support\Facades\DB;

class DataImporterTest extends TestCase
{

    public $importer_instance;

    public function setUp(): void
    {

        parent::setUp(); // add this line
        \Illuminate\Support\Facades\Artisan::call('migrate:refresh');

        $url = "https://utils.crmweb.com.ph/premierleague/public/data_snake.json";
        $importer = new DataImporter($url);     // Data Importer
        $this->importer_instance = $importer;
    }

    /**  @test */
    public function is_instance_of_data_importer()
    {
        $this->assertInstanceOf(DataImporter::class, $this->importer_instance);
    }

    /** @test */
    public function if_data_is_not_empty()
    {
        $data = $this->importer_instance->get();
        $this->assertNotEquals(0, count($data["data"]));
    }
    // Test Players

    /** @test */
    public function test_first_name()
    {
        $player = new PlayerModel;
        $player->setFirstName("Juan");
        $this->assertEquals("Juan", $player->getFirstName());
    }


    /** @test */
    public function is_player_save_successfully()
    {
        $data = $this->importer_instance->get();
        $player = $data["data"]["elements"][0];
        $playerObj = new PlayerModel();
        $playerObj->set($player);
        $playerObj->save();
        $this->assertEquals(1, $playerObj->save());
    }

    /** @test */
    public function is_player_exist() {

        // Insert First
        $player= new PlayerModel();
        $player->set(["id" => 1, "code" => "ABCD", "first_name" => "Juan"]);
        $player->save();
        $this->assertNotEmpty($player->get("1"));
    }


}
