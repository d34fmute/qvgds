<?php
declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\GameId;
use QVGDS\Game\Domain\GameStatus;
use QVGDS\Game\Domain\Joker\AudienceHelp;
use QVGDS\Game\Domain\Joker\CallAFriend;
use QVGDS\Game\Domain\Joker\FiftyFifty;
use QVGDS\Game\Domain\Joker\Jokers;
use QVGDS\Game\Domain\Joker\JokerStatus;
use QVGDS\Game\Domain\ShitCoins;
use QVGDS\Game\Domain\UnknownGameException;
use QVGDS\Game\Service\GamesManager;
use QVGDS\Session\Domain\Question\Answer;
use QVGDS\Session\Domain\SessionNotFoundException;
use QVGDS\Tests\Game\GameFixtures;
use QVGDS\Tests\Game\Service\TestInMemoryGamesRepository;
use QVGDS\Tests\Session\Service\TestInMemorySessionsRepository;
use QVGDS\Tests\Session\SessionFixtures;

final class GamesManagerTest extends TestCase
{

    private TestInMemorySessionsRepository $sessions;
    private GamesManager $service;

    protected function setUp(): void
    {
        $this->sessions = new TestInMemorySessionsRepository();
        $this->service = new GamesManager(new TestInMemoryGamesRepository(), $this->sessions);
    }

    /**
     * @test
     */
    public function shouldNotStartAGameWithUnknownSession(): void
    {
        $this->expectException(SessionNotFoundException::class);
        $this->service->start(GameId::newId(), SessionFixtures::sessionId(), "Toto");
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

        self::assertEquals(SessionFixtures::question(), $question);
    }

    /**
     * @test
     */
    public function shouldAnswerFistQuestion(): void
    {
        $this->prepareGame();

        $this->service->guess(GameFixtures::gameId(), new Answer("Good answer"));

        $game = $this->service->get(GameFixtures::gameId());

        self::assertEquals(ShitCoins::fromLevel(1, GameStatus::IN_PROGRESS), $game->shitCoins());
    }

    /**
     * @test
     */
    public function shouldUseOneJoker(): void
    {
        $this->prepareGame();
        $this->service->fiftyFifty(GameFixtures::gameId());

        $game = $this->service->get(GameFixtures::gameId());

        self::assertEquals(new Jokers(new FiftyFifty(JokerStatus::ALREADY_USED), new CallAFriend(JokerStatus::AVAILABLE), new AudienceHelp(JokerStatus::AVAILABLE)), $game->jokers());
    }

    private function prepareGame(): void
    {
        $this->sessions->save(SessionFixtures::sessionWithQuestions());
        $this->service->start(GameFixtures::gameId(), SessionFixtures::sessionId(), "Toto");
    }
}
