<?php

use App\Http\Controllers\DTO\RestStartGame;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\GameId;
use QVGDS\Session\Domain\SessionId;
use QVGDS\Tests\Json\JsonHelper;

class RestStartGameTest extends TestCase
{
    #[Test]
    public function shouldDeserializeFromJson(): void
    {
        /** @var RestStartGame $restStartGame */
        $restStartGame = JsonHelper::readFromJson($this->json(), RestStartGame::class);

        $gameStart = $restStartGame->toDomain();

        self::assertEquals($gameStart->player, "toto");
        self::assertEquals($gameStart->sessionId, SessionId::from("b72ff86d-20fc-47f6-bbce-cd931a1a925d"));
        self::assertInstanceOf(GameId::class, $gameStart->gameId);
    }

    private function json(): string
    {
        return <<<'JSON'
        {
          "player": "toto",
          "session": "b72ff86d-20fc-47f6-bbce-cd931a1a925d"
        }
        JSON;

    }
}
