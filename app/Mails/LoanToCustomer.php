<?php

namespace App\Mails;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;
use App\Models\LoanPayment;
use App\Services\PDFService;
use Illuminate\Support\Str;

class LoanToCustomer extends Mailable
{
    use SerializesModels;

    /**
     * Public Variables
     */
    public $loan;
    public $company;
    public $customer;
    public $path;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($loan,$path)
    {
        $this->loan = $loan;
        $this->company = $loan->company;
        $this->customer = $loan->customer;
        $this->path=$path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Loan Request";
        $mail_content = $this->replaceTags("<p>Dear {customer.display_name},</p><p><br></p><p>The Loan Details are Attached.</p><p><br></p><p>If you have any question, feel free to contact us.</p><p><br></p><p>Thank you,</p><p>{company.name}.</p>");
        $loan=$this->loan;;
        $LoanAmount=$loan->amount;
        $loanCurrencySymbol=$loan->currency->symbol;
        $customer=Customer::find($loan->customer_id);
        $payments=LoanPayment::where('loan_id',$loan->id)->get();
        $currentCompany =  $this->company;
        $payment_prefix = $currentCompany->getSetting('payment_prefix');
        $company = $loan->company;
        // echo '<pre>',print_r($customer);exit;
       
        //Create a new pdf instance
        $pdf = new PDFService("A4");

        //Set your logo
        $pdf->setLogo($company->avatar, 180, 100);

        //Set theme color
        $pdf->setColor($company->getSetting('payment_color'));

        //Set type
        $pdf->setType(__('messages.loan_receipt_upper_case'));
        $pdf->setReference($loan->reference_number);

        $pdf->setLoanDate($loan->loan_date);

        //Set  due date
        $pdf->setDue($loan->return_date);

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
            $pdf->addLoan($loan);
            $pdf->addPayment($payments,$LoanAmount,$loanCurrencySymbol,$payment_prefix);
            $pdf->render($this->path, 'F');
            return $this->subject($subject)
            ->view('emails.mails.payment_receipt_to_customer')
            ->attach($this->path, [
                'as' => 'Loan-Statement.pdf',
                'mime' => 'application/pdf',
            ])
            ->with([
                'subject' => $subject, 
                'mail_content' => $mail_content,
                'loan'=>$this->loan
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