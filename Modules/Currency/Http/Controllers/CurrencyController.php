<?php


namespace Modules\Currency\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Currency\Http\Resources\CurrencyResource;
use Modules\Currency\Models\Currency;
use Modules\Currency\Repositories\CurrencyRepository;

class CurrencyController extends Controller
{
    public function __construct(
        protected CurrencyRepository $currencyRepository
    ){
        $this->authorizeResource(Currency::class, 'currency');
    }

    public function index()
    {
        $currencies = $this->currencyRepository->jsonPaginate();

        return CurrencyResource::collection($currencies);
    }

    public function show(Currency $currency)
    {
        return new CurrencyResource($currency);
    }

    public function rate(Currency $currency)
    {
        $this->authorize('view', $currency);

        return $currency->rate;
    }
}
