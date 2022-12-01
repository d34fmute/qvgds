<?php
declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\GameId;
use QVGDS\Game\Domain\ShitCoins;
use QVGDS\Game\Domain\UnknownGameException;
use QVGDS\Game\Service\GamesService;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Session\Domain\SessionNotFoundException;
use QVGDS\Tests\Game\GameFixtures;
use QVGDS\Tests\Game\Service\TestInMemoryGamesRepository;
use QVGDS\Tests\Session\Service\TestInMemorySessionsRepository;
use QVGDS\Tests\Session\SessionFixtures;

final class GamesServiceTest extends TestCase
{

    private TestInMemoryGamesRepository $games;
    private TestInMemorySessionsRepository $sessions;
    private GamesService $service;

    protected function setUp(): void
    {
        $this->games = new TestInMemoryGamesRepository();
        $this->sessions = new TestInMemorySessionsRepository();
        $this->service = new GamesService($this->games, $this->sessions);
    }

    /**
    * @test
    */
    public function shouldNotStartAGameWithUnknownSession(): void
    {
        $this->expectException(SessionNotFoundException::class);
        $this->service->start(GameId::newId(), SessionFixtures::sessionId());
    }

    /**
    * @test
    */
    public function shouldGetTheStartedGame(): void
    {
        $this->prepareGame();

        self::assertEquals(GameFixtures::newGame(), $this->service->get(GameFixtures::gameId()));
    }

    /**
    * @test
    */
    public function shoulListGames(): void
    {
        $this->prepareGame();

        self::assertEquals([GameFixtures::newGame()], $this->service->list());
    }

    /**
    * @test
    */
    public function shouldFailOnNotFoundGame(): void
    {
        $this->expectException(UnknownGameException::class);
        $this->service->get(GameId::newId());
    }

    /**
    * @test
    */
    public function shouldGetCurrentQuestion(): void
    {
        $this->prepareGame();

        $question = $this->service->currentQuestion(GameFixtures::gameId());

        self::assertEquals(SessionFixtures::question()->text(), $question);
    }

    /**
    * @test
    */
    public function shouldAnswerFistQuestion(): void
    {
        $this->prepareGame();

        $this->service->guess(GameFixtures::gameId(), new Answer("Good answer"));

        $game = $this->service->get(GameFixtures::gameId());

        self::assertEquals(ShitCoins::fromLevel(1), $game->shitCoins());
    }

    private function prepareGame(): void
    {
        $this->sessions->save(SessionFixtures::sessionWithQuestions());
        $this->service->start(GameFixtures::gameId(), SessionFixtures::sessionId());
    }
}
