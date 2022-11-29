<?php
declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\GameId;
use QVGDS\Game\Service\GamesService;
use QVGDS\Session\Domain\SessionNotFoundException;
use QVGDS\Tests\Game\GameFixtures;
use QVGDS\Tests\Session\Service\TestInMemorySessionsRepository;
use QVGDS\Tests\Session\SessionFixtures;

final class GamesServiceTest extends TestCase
{
    /**
    * @test
    */
    public function shouldNotStartAGameWithUnknownSession(): void
    {
        $service = new GamesService(new TestInMemorySessionsRepository());
        $this->expectException(SessionNotFoundException::class);
        $service->start(GameId::newId(), SessionFixtures::sessionId());
    }

    /**
    * @test
    */
    public function shouldGetTheStartedGame(): void
    {
        $repo = new TestInMemorySessionsRepository();
        $repo->save(SessionFixtures::sessionWithQuestions());
        $service = new GamesService($repo);

        self::assertEquals(GameFixtures::newGame(), $service->start(GameFixtures::gameId(), SessionFixtures::sessionId()));
    }
}
