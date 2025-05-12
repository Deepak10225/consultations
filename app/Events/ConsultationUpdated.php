<?php

namespace App\Events;

use App\Models\Consultation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class ConsultationUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $consultation;

    public function __construct(Consultation $consultation)
    {
        $this->consultation = $consultation;
    }

    public function broadcastOn()
    {
        return new Channel('consultation-updates');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->consultation->id,
            'title' => $this->consultation->title,
            'message' => 'Consultation updated!',
        ];
    }
}
