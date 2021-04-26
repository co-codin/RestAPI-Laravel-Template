<?php


namespace Modules\Currency\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Currency\Dto\CurrencyDto;
use Modules\Currency\Http\Requests\CurrencyCreateRequest;
use Modules\Currency\Http\Requests\CurrencyUpdateRequest;
use Modules\Currency\Http\Resources\CurrencyResource;
use Modules\Currency\Repositories\CurrencyRepository;
use Modules\Currency\Services\CurrencyStorage;

class CurrencyController extends Controller
{
    public function __construct(
        protected CurrencyRepository $currencyRepository,
        protected CurrencyStorage $currencyStorage
    ){}

    public function store(CurrencyCreateRequest $request)
    {
        $currency = $this->currencyStorage->store(CurrencyDto::fromFormRequest($request));

        return new CurrencyResource($currency);
    }

    public function update(int $currency, CurrencyUpdateRequest $request)
    {
        $currencyModel = $this->currencyRepository->find($currency);

        $currencyModel = $this->currencyStorage->update($currencyModel, CurrencyDto::fromFormRequest($request));

        return new CurrencyResource($currencyModel);
    }

    public function destroy(int $currency)
    {
        $currencyModel = $this->currencyRepository->find($currency);

        $this->currencyStorage->delete($currencyModel);

        return response()->noContent();
    }
}
