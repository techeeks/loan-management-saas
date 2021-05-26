<?php

namespace App\Mails;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;
use App\Models\LoanPayment;
use App\Services\PDFService;
use Illuminate\Support\Str;
use App\Models\LoanRequest;

class PaymentToCustomer extends Mailable
{
    use SerializesModels;

    /**
     * Public Variables
     */
    public $loan;
    public $customer;
    public $path;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payment,$path)
    {
        $this->payment = $payment;
        $this->path=$path;
        $this->company=$payment->company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Payment Invoice";
        $payment =$this->payment;
        $loan=LoanRequest::find($payment->loan_id);
        $customer=Customer::find($loan->customer_id);
        $this->customer=$customer;
        $currentCompany =  $this->company;
        $payment_prefix = $currentCompany->getSetting('payment_prefix');
        $company = $this->company;
        // echo '<pre>',print_r($customer);exit;
        
        $mail_content = $this->replaceTags("<p>Dear {customer.display_name},</p><p><br></p><p>The Payment Details are Attached.</p><p><br></p><p>If you have any question, feel free to contact us.</p><p><br></p><p>Thank you,</p><p>{company.name}.</p>");
        //Create a new pdf instance
        $pdf = new PDFService("A4");

        //Set your logo
        $pdf->setLogo($company->avatar, 180, 100);

        //Set theme color
        $pdf->setColor($company->getSetting('payment_color'));

        //Set type
        $pdf->setType(__('messages.payment_receipt_upper_case'));
        $pdf->setReference($payment_prefix.'-'.$payment->payment_number);

        // Hide headers
        
        $pdf->setFrom([
            $company->name,
            $company->billing->address_1 ?? '' ,
            $company->billing->city ?? '' . $company->billing->state ?? '',
            $company->billing->country->name ?? '',
            $company->billing->phone ?? '',
            $company->vat_number ? __('messages.vat_number') . ' ' . $company->vat_number : '',
            '',
            ]);
            
            //Set to
        $pdf->setTo([
            $customer->display_name,
            $customer->email,
            $customer->phone,
            $customer->billing->address_1 ?? '',
            $customer->billing->city ?? '' . $customer->billing->state ?? '',
            $customer->billing->country->name ?? '',
            '',
            ]);
            $paymentem[]=$payment;
        $pdf->addPayment($paymentem,$loan->amount,$loan->currency->symbol,$payment_prefix);

            $pdf->render($this->path, 'F');
            return $this->subject($subject)
            ->view('emails.mails.payment_receipt_to_customer')
            ->attach($this->path, [
                'as' => 'payment-receipt.pdf',
                'mime' => 'application/pdf',
            ])
            ->with([
                'subject' => $subject, 
                'mail_content' => $mail_content,
                'payment'=>$this->payment,
                'company'=>$this->company,
            ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function replaceTags($text) {
        // $invoice_url = route('customer_portal.invoices.details', ['customer' => $this->customer->uid, 'invoice' => $this->invoice->uid]);
        $tag_list = [
            '{company.name}' => $this->company->name,
            '{customer.display_name}' => $this->customer->display_name,
            '{customer.contact_name}' => $this->customer->display_name,
            '{customer.email}' => $this->customer->email,
            '{customer.phone}' => $this->customer->phone,
            // '{invoice.number}' => $this->invoice->invoice_number,
            // '{loan.link}' => '<a href="'. $invoice_url .'">'. $invoice_url .'</a>',
            // '{invoice.date}' => $this->invoice->formatted_invoice_date,
            // '{invoice.due_date}' => $this->invoice->formatted_expiry_date,
            // '{invoice.reference}' => $this->invoice->reference_number,
            // '{invoice.notes}' => $this->invoice->notes,
            // '{invoice.sub_total}' => money($this->invoice->sub_total, $this->invoice->currency_code)->format(),
            // '{invoice.total}' => money($this->invoice->total, $this->invoice->currency_code)->format(),
        ];
        foreach ($tag_list as $tag => $value) {
            $text = str_replace($tag, $value, $text);
        }
        return $text;
    }
}