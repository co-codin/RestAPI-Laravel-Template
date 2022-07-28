<?php


namespace Modules\Currency\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Currency\Http\Resources\CurrencyResource;
use Modules\Currency\Repositories\CurrencyRepository;

class CurrencyController extends Controller
{
    public function __construct(
        protected CurrencyRepository $currencyRepository
    ){}

    public function index()
    {
        $currencies = $this->currencyRepository->jsonPaginate();

        return CurrencyResource::collection($currencies);
    }

    public function show(int $currency)
    {
        $currency = $this->currencyRepository->find($currency);

        return new CurrencyResource($currency);
    }

    public function rate(int $currency)
    {
        $currency = $this->currencyRepository->find($currency);

        return $currency->rate;
    }
}
