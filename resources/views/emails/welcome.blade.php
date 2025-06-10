@component('mail::message')
    # Welcome, {{ $user->name }}

    Thank you for registering with the Employee Time Tracker system.

    @component('mail::button', ['url' => url('/')])
        Login Here
    @endcomponent

    Thanks,
    {{ config('app.name') }}
@endcomponent
