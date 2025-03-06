<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nrp' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $role = $this->input('role');
        $identifiedUser = $role === "mahasiswa" ? "nrp" : "nip";

        $credentials = [
            $identifiedUser => $this->input('identifier'), // Use correct field
            'password' => $this->input('password'),
        ];

         // Explicitly use the guard directly here for authentication
         if ($role === 'mahasiswa') {
            if (!Auth::guard('mahasiswa')->attempt($credentials, $this->boolean('remember'))) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'identifier' => trans('auth.failed'),
                ]);
            }
        } else {
            if (!Auth::guard('karyawan')->attempt($credentials, $this->boolean('remember'))) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'identifier' => trans('auth.failed'),
                ]);
            }
        }

        Log::info("User authenticated successfully!");

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
