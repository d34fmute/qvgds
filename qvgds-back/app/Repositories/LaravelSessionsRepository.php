<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\LaravelSession;
use QVGDS\Session\Domain\Session;
use QVGDS\Session\Domain\SessionId;
use QVGDS\Session\Domain\SessionsRepository;
use Ramsey\Uuid\Uuid;

final class LaravelSessionsRepository implements SessionsRepository
{

    public function save(Session $session): Session
    {
        $laravelSession = new LaravelSession();
        $laravelSession->id = $session->id()->toString();
        $laravelSession->name = $session->name();
        $laravelSession->save();

        return $session;
    }

    public function get(SessionId $id): ?Session
    {
        return null;
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     */
    public function list(): array
    {

        return LaravelSession::all()->map(fn(LaravelSession $s): Session =>
            new Session(
                new SessionId(Uuid::fromString($s->id)), $s->name)
            )
            ->toArray();
    }
}