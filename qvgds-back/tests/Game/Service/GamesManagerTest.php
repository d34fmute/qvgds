<?php
declare(strict_types=1);


use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QVGDS\Game\Domain\GameId;
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

    #[Test]
    public function shouldNotStartAGameWithUnknownSession(): void
    {
        $this->expectException(SessionNotFoundException::class);
        $this->service->start(GameFixtures::gameStart());
    }

    #[Test]
    public function shouldGetTheStartedGame(): void
    {
        $this->prepareGame();

        self::assertEquals(GameFixtures::newGame(), $this->service->get(GameFixtures::gameId()));
    }

    #[Test]
    public function shoulListGames(): void
    {
        $this->prepareGame();

        self::assertEquals([GameFixtures::newGame()], $this->service->list());
    }

    #[Test]
    public function shouldFailOnNotFoundGame(): void
    {
        $this->expectException(UnknownGameException::class);
        $this->service->get(GameId::newId());
    }

    #[Test]
    public function shouldGetCurrentQuestion(): void
    {
        $this->prepareGame();

        $question = $this->service->currentQuestion(GameFixtures::gameId());

        self::assertEquals(SessionFixtures::question(), $question);
    }

    #[Test]
    public function shouldAnswerFirstQuestion(): void
    {
        $this->prepareGame();

        $this->service->guess(GameFixtures::gameId(), new Answer("Good answer"));

        $game = $this->service->get(GameFixtures::gameId());

        self::assertEquals(ShitCoins::ONE_HUNDRED, $game->shitCoins());
    }

    #[Test]
    public function shouldUseOneJoker(): void
    {
        $this->prepareGame();
        $this->service->fiftyFifty(GameFixtures::gameId());

        $game = $this->service->get(GameFixtures::gameId());

        self::assertEquals(new Jokers(new FiftyFifty(JokerStatus::ALREADY_USED), new CallAFriend(JokerStatus::AVAILABLE), new AudienceHelp(JokerStatus::AVAILABLE)), $game->jokers());
    }

    #[Test]
    public function shouldForgiveAGame(): void
    {
        $this->prepareGame();
        $this->service->forgive(GameFixtures::gameId());

        $game = $this->service->get(GameFixtures::gameId());

        $forgivenGame = GameFixtures::newGame();
        $forgivenGame->forgive();

        self::assertEquals($forgivenGame, $game);
    }

    private function prepareGame(): void
    {
        $this->sessions->save(SessionFixtures::sessionWithQuestions());
        $this->service->start(GameFixtures::gameStart());
    }
}
