<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class OrderEntry extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
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
        $mail = Mail::send([],[],function($message){
            $message->from('htsit01@gmail.com')
                ->to('htsit01@gmail.com')
                ->subject('Welcome')
                ->setBody('Hi, welcome User');
        });

        if($mail){
            return response()->json([
                "messaage"=>"sukses"
            ]);
        }
    }
}
