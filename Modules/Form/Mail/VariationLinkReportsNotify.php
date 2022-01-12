<?php

namespace Modules\Form\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection as SupportCollection;
use Modules\Product\Enums\SupplierEnum;
use Modules\Product\Models\Product;

class VariationLinkReportsNotify extends Mailable implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 5;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 60;

    public function __construct(
        private SupportCollection $reports
    ) {}

    /**
     * Build the message.
     *
     * @return $this
     * @throws \Exception
     */
    public function build()
    {
        $stream = $this->getCsvStream();

        $mailable = $this
            ->from('admin@medeq.ru', 'Medeq')
            ->subject("Парсер коммерческой информации завершил работу")
            ->html("")
            ->attachData(stream_get_contents($stream), 'report-' . Carbon::now()->toDateTimeString() . '.csv', [
                'mime' => 'text/csv',
            ]);

        fclose($stream);

        return $mailable;
    }

    /**
     * @return resource|false
     */
    private function getCsvStream(): mixed
    {
        $stream = fopen('php://temp', "rb+");

        $content = [
            'Полное название товара',
            'ID связи',
            'Название поставщика',
            'Описание проблемы',
            'Ссылка на редактирование проблемной связи в админке',
            'Комментарий',
        ];

        fputcsv($stream, $content, ',');

        foreach ($this->reports as $report) {
            $product = Product::with(['brand'])->find($report['product_id']);

            $content = [];

            $content['productName'] =
                (
                    $product?->brand->name . ' '
                    . $product?->name . ' '
                    . $report['variation_name']
                ) ?? 'product not found';

            $content['variationLinkId'] = $report['id'];
            $content['supplier'] = SupplierEnum::getDescription($report['supplier']);
            $content['message'] = $report['message'];
            $content['variationLinkEditUrl'] = config('app.site_url') . "/admin/products/{$report['product_id']}/configurator";
            $content['comment'] = $report['comment'];

            fputcsv($stream, $content, ',');
        }

        rewind($stream);

        return $stream;
    }
}
