<?php

namespace App\Application\UseCases\Auth;

use App\Domain\Repositories\PasswordResetTokenRepositoryInterface;
use App\Domain\Services\ConfigServiceInterface;
use App\Domain\Services\HashServiceInterface;
use App\Domain\Services\MailServiceInterface;
use App\Domain\Services\StringGeneratorInterface;
use App\Shared\Constants\DateFormat;
use DateTimeImmutable;

class ForgotPasswordUseCase
{
    public function __construct(
        protected PasswordResetTokenRepositoryInterface $passwordResetTokenRepository,
        protected MailServiceInterface $mailService,
        protected HashServiceInterface $hashService,
        protected StringGeneratorInterface $stringGenerator,
        protected ConfigServiceInterface $configService,
    ) {
    }

    /**
     * Execute forgot password use case
     *
     * @param string $email
     * @return void
     */
    public function execute(string $email): void
    {
        $expiredHours = $this->configService->get('common.password_reset_token_expired', 24);
        $expiredAt = (new DateTimeImmutable())->modify("+{$expiredHours} hours");

        $tokenData = [
            'token' => $this->hashService->make($this->stringGenerator->random(60)),
            'expired_at' => $expiredAt->format(DateFormat::DATETIME_YMD_HIS),
        ];

        $existingToken = $this->passwordResetTokenRepository->findByEmail($email);

        if ($existingToken) {
            $token = $this->passwordResetTokenRepository->updateByEmail($email, $tokenData);
        } else {
            $token = $this->passwordResetTokenRepository->create([
                'email' => $email,
                ...$tokenData,
            ]);
        }

        // Send email
        $mailInfo = $this->configService->get('common.mail.reset_password');
        $feUrl = $this->configService->get('common.fe_url');
        $params = 'token=' . urlencode($token->token) . '&email=' . urlencode($email);
        $url = $feUrl . "/reset-password?{$params}";

        $this->mailService->sendEmail($email, $mailInfo['subject'], $mailInfo['template'], ['url' => $url]);
    }
}
