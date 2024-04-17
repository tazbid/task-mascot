<?php

namespace App\Jobs\Employee;

use App\Mail\Employee\EmployeeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmployeeMailJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $send_mail, $details, $subject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($send_mail, $details, $subject) {
        $this->send_mail = $send_mail;
        $this->details   = $details;
        $this->subject   = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $email = new EmployeeMail($this->details, $this->subject);
        Mail::to($this->send_mail)->send($email);
    }
}
