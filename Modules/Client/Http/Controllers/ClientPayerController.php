<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Client\Repositories\ClientPayerRepository;
use Modules\Client\Repositories\ClientRepository;
use Modules\Client\Services\ClientPayerStorage;

class ClientPayerController extends Controller
{
    public function __construct(
        protected ClientPayerRepository $clientPayerRepository,
        protected ClientRepository $clientRepository,
        protected ClientPayerStorage $clientPayerStorage
    ){}

    public function index()
    {

    }
}
