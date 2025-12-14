<?php

namespace App\Http\Rules\Auth;

use App\Domain\Repositories\PasswordResetTokenRepositoryInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VerifyTokenRule implements ValidationRule
{
    protected ?string $email;

    public function __construct(?string $email)
    {
        $this->email = $email;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->email) {
            $fail(__('validation.token_invalid'));
            return;
        }

        $token = app(PasswordResetTokenRepositoryInterface::class)->findByEmail($this->email);

        if (!$token || $value !== $token->token) {
            $fail(__('validation.token_invalid'));
            return;
        }

        if ($token->isExpired()) {
            $fail(__('validation.token_expired'));
        }
    }
}
