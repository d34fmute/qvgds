<?php
declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use QVGDS\Session\Domain\Session;
use QVGDS\Session\Domain\SessionId;
use QVGDS\Session\Service\SessionsManager;
use QVGDS\Tests\Session\Service\TestInMemorySessionsRepository;

final class SessionManagerTest extends TestCase
{
    /**
    * @test
    */
    public function shouldCreateANewSession(): void
    {
        $service = new SessionsManager(new TestInMemorySessionsRepository());

        $sessionId = SessionId::newId();
        $service->create($sessionId, "toto");

        $session = new Session($sessionId, "toto");
        $this->assertEquals($session, $service->get($sessionId));
    }
}