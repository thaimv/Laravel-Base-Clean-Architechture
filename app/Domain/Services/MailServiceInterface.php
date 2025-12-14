<?php

namespace App\Domain\Services;

interface MailServiceInterface
{
    /**
     * Send email
     *
     * @param string|array $emails
     * @param string $subject
     * @param string $template
     * @param array $data
     * @return bool
     */
    public function sendEmail(string|array $emails, string $subject, string $template, array $data): bool;
}
