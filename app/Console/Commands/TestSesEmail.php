<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestSesEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:ses-email {email : Email address to send test to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test AWS SES email configuration by sending a test email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');

        try {
            $this->info("Attempting to send test email to: {$email}");

            Mail::send('emails.test', [], function ($message) use ($email) {
                $message->to($email)
                        ->subject('Test Email from AWS SES');
            });

            $this->info("✓ Test email sent successfully to {$email}");
            $this->info("Configuration:");
            $this->line("  Driver: " . config('mail.driver'));
            $this->line("  Host: " . config('mail.host'));
            $this->line("  Port: " . config('mail.port'));
            $this->line("  From: " . config('mail.from.address'));
            $this->line("  From Name: " . config('mail.from.name'));

            return true;
        } catch (\Exception $e) {
            $this->error("✗ Error sending email: " . $e->getMessage());
            $this->error("Code: " . $e->getCode());
            return false;
        }
    }
}
