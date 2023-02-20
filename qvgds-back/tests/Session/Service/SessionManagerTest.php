<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QVGDS\Session\Domain\Session;
use QVGDS\Session\Domain\SessionId;
use QVGDS\Session\Domain\SessionNotFoundException;
use QVGDS\Session\Service\SessionsManager;
use QVGDS\Tests\Session\Service\TestInMemorySessionsRepository;
use QVGDS\Tests\Session\SessionFixtures;

final class SessionManagerTest extends TestCase
{
    #[Test]
    public function shouldCreateANewSession(): void
    {
        $service = new SessionsManager(new TestInMemorySessionsRepository());

        $sessionId = SessionId::newId();
        $service->create($sessionId, "toto");

        $session = new Session($sessionId, "toto");
        $this->assertEquals($session, $service->get($sessionId));
    }

    #[Test]
    public function shouldFailToRetrieveUnknownSession(): void
    {
        $service = new SessionsManager(new TestInMemorySessionsRepository());

        $this->expectException(SessionNotFoundException::class);

        $service->get(SessionFixtures::sessionId());
    }

    #[Test]
    public function shouldNotAddQuestionOnUnknowSession(): void
    {
        $service = new SessionsManager(new TestInMemorySessionsRepository());

        $this->expectException(SessionNotFoundException::class);

        $service->addQuestion(SessionFixtures::sessionId(), SessionFixtures::questionToAdd());
    }

    #[Test]
    public function shouldAddAQuestion(): void
    {
        $sessions = new TestInMemorySessionsRepository();
        $sessions->save(SessionFixtures::sessionWithoutQuestions());

        $service = new SessionsManager($sessions);

        $service->addQuestion(SessionFixtures::sessionId(), SessionFixtures::questionToAdd());

        $session = $service->get(SessionFixtures::sessionId());

        self::assertEquals([SessionFixtures::question()], $session->questions());
    }

    #[Test]
    public function shouldListSessions(): void
    {
        $sessions = new TestInMemorySessionsRepository();
        $session = new Session(SessionId::newId(), "toto", SessionFixtures::question());
        $sessions->save($session);
        $sessions->save(SessionFixtures::sessionWithoutQuestions());

        $service = new SessionsManager($sessions);

        self::assertEquals([$session, SessionFixtures::sessionWithoutQuestions()], $service->list());
    }
}
