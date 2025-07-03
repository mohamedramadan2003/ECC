<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExamSubmittedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $exam;
public $committees;

public function __construct($exam, $committees)
{
    $this->exam = $exam;
    $this->committees = $committees;
}


    public function build()
    {
        return $this->from('noreply@ecc.edu.eg')
            ->subject( 'ECC')
            ->view('emails.exam_submitted');
    }
}
