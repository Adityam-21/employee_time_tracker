@component('mail::message')
    # Your Export is Ready!

    Click the button below to download your time logs file.

    @component('mail::button', ['url' => $downloadUrl])
        Download Export
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
