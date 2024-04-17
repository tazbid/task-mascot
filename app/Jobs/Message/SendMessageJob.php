<?php

namespace App\Jobs\Message;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessageJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $finalUrl;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($finalUrl) {
        $this->finalUrl = $finalUrl;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->finalUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_POST, FALSE);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSLVERSION, 0);

        curl_exec($curl);
        curl_close($curl);
    }
}
