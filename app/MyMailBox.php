<?php

use BeyondCode\Mailbox\Facades\Mailbox;
use BeyondCode\Mailbox\InboundEmail;

Mailbox::from('postmaster@sandboxe9d2b733d1ba4db38e25a92286545ce8.mailgun.org', MyMailbox::class);

class MyMailbox
{
    public function __invoke(InboundEmail $email)
    {
        $subject = $email->subject();
        $email->save();
        $mail = new InboundEmail(['message' => $email->message()]);
        $mail->save();
        InboundEmail::create(['message' => $email->message()]);
    }

    public function __construct()
    {
        
    }
}
