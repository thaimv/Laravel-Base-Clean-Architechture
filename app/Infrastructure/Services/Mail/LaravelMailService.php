<?php

namespace App\Infrastructure\Services\Mail;

use App\Domain\Services\MailServiceInterface;
use App\Infrastructure\Mail\MailNotify;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LaravelMailService implements MailServiceInterface
{
    /**
     * Send email
     *
     * @param string|array $emails
     * @param string $subject
     * @param string $template
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function sendEmail(string|array $emails, string $subject, string $template, array $data): bool
    {
        try {
            Mail::to($emails)->send(new MailNotify($template, $subject, $data));

            return true;
        } catch (\Exception $exception) {
            Log::error('Send email : ' . $exception->getMessage());
            Log::error('Email subject : ' . $subject);
            Log::error('Email template : ' . $template);
            Log::error('Email data : ' . json_encode($data));

            throw new \Exception($exception->getMessage());
        }
    }
}
