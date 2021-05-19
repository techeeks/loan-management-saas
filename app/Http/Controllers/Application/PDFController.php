<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Estimate;
use App\Models\Payment;
use App\Services\PDFService;
use Illuminate\Http\Request;
use App\Models\LoanPayment;
use App\Models\LoanRequest;

class PDFController extends Controller
{
    /**
     * Get Invoice Pdf
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return pdf
     */
    public function invoice(Request $request)
    {
        $invoice = Invoice::findByUid($request->invoice);
        $company = $invoice->company;
        $customer = $invoice->customer;

        //Create a new pdf instance
        $pdf = new PDFService("A4");

        //Set your logo
        $pdf->setLogo($company->avatar, 180, 100);

        //Set theme color
        $pdf->setColor($company->getSetting('invoice_color'));

        //Set type
        $pdf->setType(__('messages.invoice_upper_case'));

        // Set Tax per Item
        $pdf->setTaxPerItem($invoice->tax_per_item);

        // Set Discount per Item
        $pdf->setDiscountPerItem($invoice->discount_per_item);

        //Set reference
        $pdf->setReference($invoice->invoice_number);

        //Set date
        $pdf->setDate($invoice->formatted_invoice_date);

        //Set  due date
        $pdf->setDue($invoice->formatted_due_date);

        //Set From
        $pdf->setFrom([
            $company->name,
            $company->billing->address_1,
            $company->billing->address_2,
            $company->billing->city ?? '' . $company->billing->state ?? '',
            $company->billing->country->name ?? '',
            $company->billing->phone ?? '',
            $company->vat_number ? __('messages.vat_number') . ' ' . $company->vat_number : '',
        ]);
 
        //Set to
        $pdf->setTo([
            $customer->display_name,
            $customer->billing->address_1,
            $customer->billing->address_2,
            $customer->billing->city ?? '' . $customer->billing->state ?? '',
            $customer->billing->country->name ?? '',
            $customer->billing->phone ?? '',
            $customer->vat_number ? __('messages.vat_number') . ' ' . $customer->vat_number : '',
        ]);

        // Add items
        foreach ($invoice->items as $item) {
            $pdf->addItem(
                $item->product->name, 
                $item->product->description,
                $item->quantity,
                $item->getTotalPercentageOfTaxes(), 
                money($item->price, $invoice->currency_code)->format(), 
                $item->discount_val, 
                money($item->total, $invoice->currency_code)->format()
            );
        }

        // Set Sub Total
        $pdf->addTotal(__('messages.sub_total'), money($invoice->sub_total, $invoice->currency_code)->format());

        // Set Taxes Total
        if($invoice->tax_per_item == false) {
            if ($invoice->getTotalPercentageOfTaxes() !== 0) {
                $pdf->addTotal(__('messages.tax'), $invoice->getTotalPercentageOfTaxes(). ' %');
            }
        }

        // Set Discount Total
        if($invoice->discount_per_item == false) {
            if ($invoice->discount_val !== 0) {
                $pdf->addTotal(__('messages.discount'), (int) $invoice->discount_val . ' %');
            }
        }

        // Set Total
        $pdf->addTotal(__('messages.total'), money($invoice->total, $invoice->currency_code)->format(), true);

        //Add notes
        $pdf->addParagraph($invoice->notes);

        //Set footernote
        $pdf->setFooternote($company->getSetting('invoice_footer'));

        // Add Status Badge
        $pdf->addBadge($invoice->paid_status);

        //Render or Download
        if($request->has('download')) {
            $pdf->render($invoice->invoice_number . '.pdf', 'D');
        } else {
            $pdf->render($invoice->invoice_number . '.pdf', 'I');
        }
    }

    /**
     * Get Estimate Pdf
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return pdf
     */
    public function estimate(Request $request)
    {
        $estimate = Estimate::findByUid($request->estimate);
        $company = $estimate->company;
        $customer = $estimate->customer;

        //Create a new pdf instance
        $pdf = new PDFService("A4");

        //Set your logo
        $pdf->setLogo($company->avatar, 180, 100);

        //Set theme color
        $pdf->setColor($company->getSetting('estimate_color'));

        //Set type
        $pdf->setType(__('messages.estimate_upper_case'));

        // Set Tax per Item
        $pdf->setTaxPerItem($estimate->tax_per_item);

        // Set Discount per Item
        $pdf->setDiscountPerItem($estimate->discount_per_item);

        //Set reference
        $pdf->setReference($estimate->estimate_number);

        //Set date
        $pdf->setDate($estimate->formatted_estimate_date);

        //Set  due date
        $pdf->setDue($estimate->formatted_expiry_date);

        //Set From
        $pdf->setFrom([
            $company->name,
            $company->billing->address_1,
            $company->billing->city ?? '' . $company->billing->state ?? '',
            $company->billing->country->name ?? '',
            $company->billing->phone ?? '',
            $company->vat_number ? __('messages.vat_number') . ' ' . $company->vat_number : '',
        ]);

        //Set to
        $pdf->setTo([
            $customer->display_name,
            $customer->billing->address_1,
            $customer->billing->address_2,
            $customer->billing->city ?? '' . $customer->billing->state ?? '',
            $customer->billing->country->name ?? '',
            $customer->billing->phone ?? '',
            $customer->vat_number ? __('messages.vat_number') . ' ' . $customer->vat_number : '',
        ]);

        // Add items
        foreach ($estimate->items as $item) {
            $pdf->addItem(
                $item->product->name, 
                $item->product->description,
                $item->quantity,
                $item->getTotalPercentageOfTaxes(), 
                money($item->price, $estimate->currency_code)->format(), 
                $item->discount_val, 
                money($item->total, $estimate->currency_code)->format()
            );
        }

        // Set Sub Total
        $pdf->addTotal(__('messages.sub_total'), money($estimate->sub_total, $estimate->currency_code)->format());

        // Set Taxes Total
        if($estimate->tax_per_item == false) {
            if ($estimate->getTotalPercentageOfTaxes() !== 0) {
                $pdf->addTotal(__('messages.tax'), $estimate->getTotalPercentageOfTaxes(). ' %');
            }
        }

        // Set Discount Total
        if($estimate->discount_per_item == false) {
            if ($estimate->discount_val !== 0) {
                $pdf->addTotal(__('messages.discount'), (int) $estimate->discount_val . ' %');
            }
        }

        // Set Total
        $pdf->addTotal(__('messages.total'), money($estimate->total, $estimate->currency_code)->format(), true);

        //Add notes
        $pdf->addParagraph($estimate->notes);

        //Set footernote
        $pdf->setFooternote($company->getSetting('estimate_footer'));

        // Add Status Badge
        $pdf->addBadge($estimate->status);

        //Render or Download
        if($request->has('download')) {
            $pdf->render($estimate->estimate_number . '.pdf', 'D');
        } else {
            $pdf->render($estimate->estimate_number . '.pdf', 'I');
        }
    }

    /**
     * Get Payment Pdf
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return pdf
     */
    public function payment(Request $request)
    {
        $payment = LoanPayment::find($request->payment);
        $loan=LoanRequest::find($payment->loan_id);
        $user = $request->user();
        $customer=Customer::find($loan->customer_id);
        $currentCompany = $user->currentCompany();
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
            // $pdf->setHideHeader(false);
        // Set Sub Total
        $pdf->addTotal(__('messages.payment_date'), $payment->payment_date);
        $pdf->addTotal(__('messages.payment_#'), $payment_prefix.'-'.$payment->payment_number);
        $pdf->addTotal(__('messages.loan_reference_number'), $loan->reference_number);
        $pdf->addTotal(__('messages.payment_method'), $payment->payment_method->name ?? '');

        // Set Total
        $pdf->addTotal(__('messages.total'), currencyFormat($loan->amount,$loan->currency->symbol));
        $pdf->addTotal(__('messages.paid_amount'), currencyFormat($payment->amount,$loan->currency->symbol));
        $pdf->addTotal(__('messages.due_amount'), currencyFormat($loan->amount-$loan->totalPaid($loan->id),$loan->currency->symbol), true);
        

        //Add notes
        $pdf->addParagraph($payment->notes);

        //Set footernote
        // $pdf->setFooternote("any");

        //Render or Download
        if($request->has('download')) {
            $pdf->render($payment->payment_number . '.pdf', 'D');
        } else {
            $pdf->render($payment->payment_number . '.pdf', 'I');
        }
    }

    public function loan(Request $request)
    {
       
        $loan=LoanRequest::find($request->loan);
        $LoanAmount=$loan->amount;
        $user = $request->user();
        $customer=Customer::find($loan->customer_id);
        $payments=LoanPayment::where('loan_id',$loan->id)->orderBy('id','DESC')->get();
        $currentCompany = $user->currentCompany();
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
            // $pdf->setHideHeader(false);
            foreach($payments as $payment){
        // Set Sub Total
       
                $pdf->addTotal(__('messages.payment_date'), $payment->payment_date);
                $pdf->addTotal(__('messages.payment_#'), $payment_prefix.'-'.$payment->payment_number);
                $pdf->addTotal(__('messages.payment_method'), $payment->payment_method->name ?? '');

                // // Set Total
                $pdf->addTotal(__('messages.total'), $loan->amount);
                $pdf->addTotal(__('messages.paid_amount'), currencyFormat($payment->amount,$loan->currency->symbol));
                $pdf->addTotal(__('messages.due_amount'), currencyFormat($LoanAmount-$payment->amount,$loan->currency->symbol), true);
            }
        

        // //Add notes
        // $pdf->addParagraph($payment->notes);

        //Set footernote
        // $pdf->setFooternote("any");

        //Render or Download
        if($request->has('download')) {
            $pdf->render($loan->reference_number . '.pdf', 'D');
        } else {
            $pdf->render($loan->reference_number . '.pdf', 'I');
        }
    }
}
