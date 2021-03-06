<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAuthorPost extends Notification implements ShouldQueue
{
  use Queueable;

  private $post;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(Post $post)
  {
    $this->post = $post;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    return (new MailMessage)
      ->greeting('Hello Admin!')
      ->subject('New Post Approval Needed')
      ->line('New Post Created By ' . $this->post->user->username)
      ->line('To approve the post click view button.')
      ->line('Post title : ' . $this->post->title)
      ->action('View', url(\route('posts.publishOrUnPublish', $this->post->id)))
      ->line('Thank you for using our application!');
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    return [
      //
    ];
  }
}
