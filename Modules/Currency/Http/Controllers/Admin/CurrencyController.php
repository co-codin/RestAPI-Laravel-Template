<?php


namespace Modules\Currency\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Currency\Dto\CurrencyDto;
use Modules\Currency\Http\Requests\CurrencyCreateRequest;
use Modules\Currency\Http\Requests\CurrencyUpdateRequest;
use Modules\Currency\Http\Resources\CurrencyResource;
use Modules\Currency\Models\Currency;
use Modules\Currency\Repositories\CurrencyRepository;
use Modules\Currency\Services\CurrencyStorage;

class CurrencyController extends Controller
{
    public function __construct(
        protected CurrencyStorage $currencyStorage,
        protected CurrencyRepository $currencyRepository
    ){}

    public function store(CurrencyCreateRequest $request)
    {
        $this->authorize('create', Currency::class);

        $currency = $this->currencyStorage->store(CurrencyDto::fromFormRequest($request));

        return new CurrencyResource($currency);
    }

    public function update(int $currency, CurrencyUpdateRequest $request)
    {
        $currency = $this->currencyRepository->find($currency);

        $this->authorize('update', $currency);

        $currency = $this->currencyStorage->update($currency, CurrencyDto::fromFormRequest($request));

        return new CurrencyResource($currency);
    }

    public function destroy(int $currency)
    {
        $currency = $this->currencyRepository->find($currency);

        $this->authorize('delete', $currency);

        $this->currencyStorage->delete($currency);

        return response()->noContent();
    }
}
