<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateData extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
	
	public $model;
	public $log;
	 
    public function __construct($model, $log)
    {
        // print_r(class_basename($log));die;
		$this->model = $model;
		$this->log = $log;
    }
	
	public function handle($log){
		// print_r($log);die;
	}

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
	
	public function broadcastWith(){
		return [
			'model' => $this->model,
			'log' => $this->log
		];
	}
}
