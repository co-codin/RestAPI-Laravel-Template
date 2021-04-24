<?php


namespace Modules\Currency\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Currency\Repositories\CurrencyRepository;

class CurrencyController extends Controller
{
    public function __construct(
        protected CurrencyRepository $currencyRepository
    ){}

    public function index()
    {

    }

    public function show(int $currency)
    {
        
    }
}
