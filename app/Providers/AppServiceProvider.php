<?php

namespace App\Providers;

use BeyondCode\Mailbox\Facades\Mailbox;
use BeyondCode\Mailbox\InboundEmail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Mailbox::from('postmaster@sandboxe9d2b733d1ba4db38e25a92286545ce8.mailgun.org', function (InboundEmail $email) {
            $hi = "hiiiiiiii";
            dd($hi);
            $subject = $email->subject();
            $email->save();
            $mail = new InboundEmail(['message' => $email->message()]);
            $mail->save();
            InboundEmail::create(['message' => $email->message()]);
        });
    }
}
