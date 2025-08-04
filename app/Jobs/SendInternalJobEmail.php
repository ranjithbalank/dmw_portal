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
        Mail::to($this->user->email)->send(
            new NewInternalJobPosted($this->internalJob, $this->user)
        );
    }
}
