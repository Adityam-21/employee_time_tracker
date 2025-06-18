<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyWorkReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $totalHours;

    public function __construct($employee, $totalHours)
    {
        $this->employee = $employee;
        $this->totalHours = $totalHours;
    }

    public function build()
    {
        return $this->subject('Your Work Hours for Yesterday')
            ->view('emails.daily_report');
    }
}
