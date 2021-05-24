<?php

namespace Modules\Form\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Form\Forms\Form;

/**
 * Class SendToCrm
 * @package Modules\Form\Jobs
 */
class SendToCrm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Form $form
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Throwable
     */
    public function handle(): void
    {
        $properties = $this->form->getProperties();
        $product = $this->form->getProduct();
        $category = $this->form->getCategory();

        if (!is_null($category)) {
            $properties[] = [
                'property' => 'category_title',
                'value' => $category->name
            ];
        }

        if (!is_null($product)) {
            $properties[] = [
                'property' => 'product_title',
                'value' => optional($product->brand)->name . ' ' . $product->name
            ];
        } /*else if(($category = $lead->getProperty('category'))) {
            $properties[] = ['property' => 'category_title', 'value' => $category];
        }*/

        $client = new Client([
            'base_uri' => config('services.crm.domain')
        ]);

        $options = [
            'form_params' => [
                'form_name' => $this->form->title(),
                'page' => $this->form->getPage(),
                'utm' => $this->form->getUtm(),
                'properties' => $properties
            ],
        ];

        try {
            $client->post('/v1/lead/create/?access-token=' . config('services.crm.token'), $options);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
