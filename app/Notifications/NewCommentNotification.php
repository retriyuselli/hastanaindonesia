<?php

namespace App\Notifications;

use App\Models\BlogComment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $comment;

    /**
     * Create a new notification instance.
     */
    public function __construct(BlogComment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Komentar Baru di Blog: ' . $this->comment->blog->title)
            ->line('Ada komentar baru yang menunggu persetujuan.')
            ->line('**Dari:** ' . $this->comment->name)
            ->line('**Email:** ' . $this->comment->email)
            ->line('**Artikel:** ' . $this->comment->blog->title)
            ->line('**Komentar:**')
            ->line('"' . $this->comment->comment . '"')
            ->action('Lihat & Setujui Komentar', url('/admin/blog-comments/' . $this->comment->id))
            ->line('Terima kasih!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'comment_id' => $this->comment->id,
            'blog_id' => $this->comment->blog_id,
            'blog_title' => $this->comment->blog->title,
            'commenter_name' => $this->comment->name,
            'commenter_email' => $this->comment->email,
            'comment_excerpt' => substr($this->comment->comment, 0, 100),
            'url' => url('/admin/blog-comments/' . $this->comment->id),
        ];
    }
}
