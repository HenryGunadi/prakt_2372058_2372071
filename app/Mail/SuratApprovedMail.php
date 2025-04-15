<?php

// app/Mail/SuratApprovedMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuratApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $surat;

    public function __construct($surat)
    {
        $this->surat = $surat;
    }

    public function build()
    {
        return $this->subject('Surat Anda Telah Disetujui')
                    ->view('emails.surat_approved');
    }
}