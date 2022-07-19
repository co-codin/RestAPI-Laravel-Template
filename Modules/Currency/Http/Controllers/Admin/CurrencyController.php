<?php


namespace Modules\Currency\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Currency\Dto\CurrencyDto;
use Modules\Currency\Http\Requests\CurrencyCreateRequest;
use Modules\Currency\Http\Requests\CurrencyUpdateRequest;
use Modules\Currency\Http\Resources\CurrencyResource;
use Modules\Currency\Models\Currency;
use Modules\Currency\Services\CurrencyStorage;

class CurrencyController extends Controller
{
    public function __construct(
        protected CurrencyStorage $currencyStorage
    ){
        $this->authorizeResource(Currency::class, 'currency');
    }

    public function store(CurrencyCreateRequest $request)
    {
        $currency = $this->currencyStorage->store(CurrencyDto::fromFormRequest($request));

        return new CurrencyResource($currency);
    }

    public function update(Currency $currency, CurrencyUpdateRequest $request)
    {
        $currency = $this->currencyStorage->update($currency, CurrencyDto::fromFormRequest($request));

        return new CurrencyResource($currency);
    }

    public function destroy(Currency $currency)
    {
        $this->currencyStorage->delete($currency);

        return response()->noContent();
    }
}
