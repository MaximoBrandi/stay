@component('mail::message')
    {{ __('Your Stay account needs to be activated!')}}

    {{ __('You can do it login in with your email and the next password temporary:') }}

    {{ $password }}

    @component('mail::button', ['url' => $loginLink])
        {{ __('Log in') }}
    @endcomponent

    {{ __('To activate your account you will need first to change your temporary password for a secure one and enable 2FA authentication.') }}
@endcomponent
