<?php

namespace App\Mail;

use App\Models\SalesOrder;
use Dompdf\Dompdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailQuote extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $pdf;

    /**
     * Create a new message instance.
     * @TODO add terms and conditions
     * @return void
     */
    public function __construct(SalesOrder $order)
    {
        $this->order = $order;

        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->isRemoteEnabled(true);
        $options->setIsHtml5ParserEnabled(true);
        $dompdf->setOptions($options);

        $dompdf->loadHtml(view('admin.invoices.templates.quote-pdf', ['detail' => $order]));
        $dompdf->setPaper('A4');

        $dompdf->render();

        // Encode pdf data so it can be queued
        $this->pdf = base64_encode($dompdf->output());
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $filename = env('APP_NAME').'-quote-'.$this->order->id.'.pdf';

        return $this->subject('You have an quote')->view('emails.send-customer-quote')
            ->attachData(base64_decode($this->pdf), $filename, [
                'mime' => 'application/pdf',
            ]);
    }
}
