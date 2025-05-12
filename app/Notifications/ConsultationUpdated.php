<?php
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ConsultationUpdated extends Notification
{
    protected $consultation;

    public function __construct($consultation)
    {
        $this->consultation = $consultation;
    }

    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'Consultation updated',
            'consultation' => $this->consultation,
        ]);
    }
}
