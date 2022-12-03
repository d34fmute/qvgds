<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use QVGDS\Session\Service\SessionsManager;
use Illuminate\Http\Response;

final class SessionsController
{
    public function __construct(private readonly SessionsManager $sessions)
    {
    }

    public function list(): Response
    {
        return $this->sessions->list();
    }

}
