<?php

namespace App\Http\Controllers\DTO;

use PHPUnit\Framework\TestCase;
use QVGDS\Tests\Game\GameFixtures;
use QVGDS\Tests\Json\JsonHelper;

class RestGameTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSerializeToJson(): void
    {
        $json = JsonHelper::writeAsJson(RestGame::from(GameFixtures::newGame()));

        self::assertEquals($this->json(), $json);
    }

    private function json(): string
    {
        return
            '{"id":"7cb03186-5430-45c2-9bdb-d5993a4ad209",'
            . '"player":"Toto",'
            . '"step":1,'
            . '"shitcoins":0,'
            . '"status":"IN_PROGRESS",'
            . '"jokers":['
            . '{"type":"FIFTY_FIFTY","status":"AVAILABLE"},'
            . '{"type":"CALL_A_FRIEND","status":"AVAILABLE"},'
            . '{"type":"AUDIENCE_HELP","status":"AVAILABLE"}]'
            . '}';
    }

}
