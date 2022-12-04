<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\LaravelSession;
use QVGDS\Session\Service\SessionsManager;
use QVGDS\Session\Domain\Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use QVGDS\Session\Domain\SessionId;

final class SessionsController
{
    public function __construct(private readonly SessionsManager $sessions)
    {
    }

    public function index(): View
    {
        $this->sessions->list();

        //
        return view('session.index');
    }

    // Display form
    public function create()
    {
        //

    }

    // Store in database
    public function store(Request $request)
    {
        // Exemple de creation
        // $session = $this->sessions->create(SessionId::newId(), 'session_test');

    }

    public function show(Session $session)
    {
        //
    }

    public function edit(Session $session)
    {
        //
    }

    public function update(Request $request, Session $session)
    {
        //
    }

    public function destroy(Session $session)
    {
        //
    }

}
