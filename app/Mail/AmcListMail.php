<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AmcListMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Datahousetechnology@gmail.com')
                    ->subject('AMC List Mail')
                    ->view('entery.amclistmail')

                    ->attach(public_path('amclistmail.blade.php'), [
                        'as' => 'amclist.pdf',
                        'mime' => 'application/pdf',

                        
                   
                    ]);
    }
}
