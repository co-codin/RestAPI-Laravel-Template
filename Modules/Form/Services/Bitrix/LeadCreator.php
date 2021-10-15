<?php


namespace Modules\Form\Services\Bitrix;


use Exception;
use Illuminate\Support\Arr;
use Medeq\Bitrix24\Facades\Bitrix24;
use Medeq\Bitrix24\Models\Crm\Lead\Lead;
use Modules\Form\Forms\Form;
use Modules\Form\Repositories\Contracts\LeadRepository;

/**
 * Class LeadCreator
 * @package Modules\Form\Services\Bitrix
 * @property Form $form
 * @property string $newLeadTitle
 * @property string $newLeadSourceId
 * @property LeadRepository $leadRepository
 */
class LeadCreator
{
    private $form;
    private $leadRepository;

    /**
     * @var string Название нового лида
     */
    private $newLeadTitle = "{{конвертация}}";

    /**
     * @var string Источник нового лида
     */
    private $newLeadSourceId = "SELF";

    public function __construct(LeadRepository $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }

    /**
     * @param Form $form
     * @return $this
     */
    public function setForm(Form $form): self
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCategoryIdFromBitrix(): ?int
    {
        $categoryEntity = $this->form->getCategory();

        if (is_null($categoryEntity)) {
            return null;
        }

        $categories = collect(
            Lead::fields()[config('bitrix24.lead_category_field_id')]['items']
        );

        $category = $categories
            ->filter(function (array $category) use ($categoryEntity) {
                return $category['value'] == $categoryEntity->title;
            })
            ->first();

        if (is_array($category) && array_key_exists('id', $category)) {
            return (int) $category['id'];
        }

        return null;
    }

    /**
     * @throws Exception
     * @throws \Throwable
     */
    public function create()
    {
        $form = $this->form;
        $roistatKey = config('bitrix24.lead_roistat_field_id');

        $lead = Lead::create([
            "title" => $this->newLeadTitle,
            config('bitrix24.lead_category_field_id') => Arr::wrap($this->getCategoryIdFromBitrix()),
            "assigned_by_id" => ($form->getAuthPhone() ?? $form->getPhone())
                ? config('bitrix24.new_deal_assigned_id')
                : config('bitrix24.no_phone_deal_assigned_id')
            ,
            "name" => $form->getAttribute('name') ?? "",
            "email" => $form->getAuthEmail() ? [['VALUE' => $form->getAuthEmail()]] : [['VALUE' => $form->getEmail()]],
            "phone" => $form->getAuthPhone() ? [['VALUE' => $form->getAuthPhone()]] : [['VALUE' => $form->getPhone()]],
            'source_id' => $this->newLeadSourceId,
            'comments' => $form->getComments(),
            'utm_source' => $form->getConcreteUtm('utm_source'),
            'utm_medium' => $form->getConcreteUtm('utm_medium'),
            'utm_campaign' => $form->getConcreteUtm('utm_campaign'),
            'utm_content' => $form->getConcreteUtm('utm_content'),
            'utm_term' => $form->getConcreteUtm('utm_term'),
            'uf_crm_56767c2bb8432' => $this->form->getProduct()
                ? $this->form->getProduct()->brand->title . " " . $this->form->getProduct()->title
                : "",
            $roistatKey => $form->getRoistatVisit(),
            //'uf_crm_1525856204' => $this->form->getCategory() ?? "",
            //'uf_crm_1525856795' => $this->form->leadType ?? "",
        ]);

        if($lead && $lead instanceof Lead && $lead->id) {
            Bitrix24::call('bizproc.workflow.start', [
                'TEMPLATE_ID' => 50,
                'DOCUMENT_ID' => ['crm', 'CCrmDocumentLead', $lead->id],
            ]);
        }
    }
}
