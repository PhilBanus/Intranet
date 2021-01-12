<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class opexIdea extends Mailable
{
    use Queueable, SerializesModels;

	public $Subject;
	public $Body;
	public $Name;
	public $Email;
	protected $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($Subject,$Body, $Name, $Email,$data=[])
    {
        //
		$this->Subject = $Subject;
		$this->Body = $Body;
		$this->Name = $Name;
		$this->Email = $Email;
		$this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		
		if($this->data['document']){
        return $this->from($this->Email)->attach($this->data['document']->getRealPath(),
                [
                    'as' => $this->data['document']->getClientOriginalName(),
                    'mime' => $this->data['document']->getClientMimeType(),
                ])
			->markdown('emails.opexIdea');
			
		}else{
			
			 return $this->from($this->Email)
			->markdown('emails.opexIdea');
		}
    }
}
