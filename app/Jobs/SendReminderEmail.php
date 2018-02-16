<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\User;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.test', ['text' => 'testTitle'], function ($message)
        {
            $message->from('no-reply@scotch.io', 'Scotch.IO');
            $message->to($this->user->email, $this->user->name)->subject('Your Reminder!');
        });
        // User::create([
        //     'name' => '123',
        //     'email' => 'test@example.com',
        // ]);
    }
}
