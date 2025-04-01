<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;  // 🛠 Thêm dòng này
use Illuminate\Support\Carbon;
use App\Models\User;
class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        //
        $this->user = $user;

        $this->verificationUrl = URL::temporarySignedRoute(
            'verification.verify',  // Laravel tự xử lý route này
            Carbon::now()->addMinutes(60), // Thời gian hết hạn (60 phút)
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Email',
        );
    }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->subject('Xác minh tài khoản của bạn')
                    ->view('mail.verify-email')
                    ->with([
                        'user' => $this->user,
                        'verificationUrl' => $this->verificationUrl,
                    ]);
    }
}
