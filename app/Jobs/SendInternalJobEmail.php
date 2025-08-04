<?php
namespace App\Jobs;

use App\Models\User;
use App\Models\InternalJobPostings;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewInternalJobPosted;

class SendInternalJobEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,Batchable;

    protected $user;
    protected $internalJob; // ✅ Renamed from $job

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, InternalJobPostings $job)
    {
        $this->user = $user;
        $this->internalJob = $job; // ✅ renamed here too
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Step 1: Get all user emails
        $emails = \App\Models\User::pluck('email')->toArray();

        // Step 2: Chunk the emails (max 500 per BCC message per Microsoft SMTP)
        collect($emails)->chunk(500)->each(function ($chunk) {
            Mail::to('noreply@yourdomain.com') // dummy "To" address
                ->bcc($chunk->toArray())
                ->send(new NewInternalJobPosted($this->internalJob));
        });
    }
}
