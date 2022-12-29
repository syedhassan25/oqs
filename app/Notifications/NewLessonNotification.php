<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class NewLessonNotification extends Notification
{
    use Queueable;
    protected $lesson;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($lesson,$user)
    {
        $this->lesson = $lesson;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    
    public function toDatabase($notifiable)
    {
        return [
            'lesson' => $this->lesson
        ];
    }
    public function broadcastOn()
    {
        // return ['sentLessonNotification'];

        return [new PrivateChannel('App.User.'.$this->user)];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'lesson' => $this->lesson,
            'count' => $notifiable->unreadNotifications->count()
        ];

        // return new BroadCastMessage([
        //     'lesson' => $this->lesson,
        //     'count' => $notifiable->unreadNotifications->count()
        // ]);
    }
}
