<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MfaTokenMail extends Mailable
{
    use SerializesModels;

    public $mfaToken;

    /**
     * Create a new message instance.
     *
     * @param string $mfaToken
     * @return void
     */
    public function __construct($mfaToken)
    {
        $this->mfaToken = $mfaToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your MFA Token')
                    ->view('emails.token')
                    ->with([
                        'mfaToken' => $this->mfaToken,
                    ]);
    }
    
}
