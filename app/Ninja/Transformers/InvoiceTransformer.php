<?php namespace App\Ninja\Transformers;

use App\Models\Account;
use App\Models\Client;
use App\Models\Invoice;
use League\Fractal;

/**
 * @SWG\Definition(definition="Invoice", required={"invoice_number"}, @SWG\Xml(name="Invoice"))
 */

class InvoiceTransformer extends EntityTransformer
{
    /**
    * @SWG\Property(property="id", type="integer", example=1, readOnly=true)
    * @SWG\Property(property="amount", type="float", example=10, readOnly=true)
    * @SWG\Property(property="balance", type="float", example=10, readOnly=true)
    * @SWG\Property(property="client_id", type="integer", example=1)
    * @SWG\Property(property="invoice_number", type="string", example="0001")
    * @SWG\Property(property="invoice_status_id", type="integer", example=1)
    */

    protected $client;

    public function __construct(Account $account, Client $client)
    {
        parent::__construct($account);

        $this->client = $client;
    }

    protected $defaultIncludes = [
        'invoice_items',
    ];

    public function includeInvoiceItems(Invoice $invoice)
    {
        return $this->collection($invoice->invoice_items, new InvoiceItemTransformer($this->account));
    }

    public function transform(Invoice $invoice)
    {
        return [
            'id' => (int) $invoice->public_id,
            'invoice_number' => $invoice->invoice_number,
            'amount' => (float) $invoice->amount,
            'balance' => (float) $invoice->balance,
            'client_id' => (int) $this->client->public_id,
            'invoice_status_id' => (int) $invoice->invoice_status_id,
            'updated_at' => $invoice->updated_at,
            'deleted_at' => $invoice->deleted_at,
            'invoice_number' => $invoice->invoice_number,
            'discount' => (double) $invoice->discount,
            'po_number' => $invoice->po_number,
            'invoice_date' => $invoice->invoice_date,
            'due_date' => $invoice->due_date,
            'terms' => $invoice->terms,
            'public_notes' => $invoice->public_notes,
            'is_deleted' => (bool) $invoice->is_deleted,
            'is_recurring' => (bool) $invoice->is_recurring,
            'frequency_id' => (int) $invoice->frequency_id,
            'start_date' => $invoice->start_date,
            'end_date' => $invoice->end_date,
            'last_sent_date' => $invoice->last_sent_date,
            'recurring_invoice_id' => (int) $invoice->recurring_invoice_id,
            'tax_name' => $invoice->tax_name,
            'tax_rate' => (float) $invoice->tax_rate,
            'amount' => (float) $invoice->amount,
            'balance' => (float) $invoice->balance,
            'is_amount_discount' => (bool) $invoice->is_amount_discount,
            'invoice_footer' => $invoice->invoice_footer,
            'partial' => (float) $invoice->partial,
            'has_tasks' => (bool) $invoice->has_tasks,
            'auto_bill' => (bool) $invoice->auto_bill,
            'account_key' => $this->account->account_key
        ];
    }
}