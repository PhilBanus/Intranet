<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Message;

class User_PD_Updated extends Mailable
{
    use Queueable, SerializesModels;
	
	public $user;
	public $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$id)
    {
        //
		$this->user = $user;
		$this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('themis@hochtief.co.uk')
			->subject('Personal Details Change')
			->markdown('emails.personal_details');
			
    }
}
