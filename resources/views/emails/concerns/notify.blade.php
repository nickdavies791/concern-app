@component('mail::message')
<p style="font-weight:lighter; font-size: 18px">Hello, {{ $user->name }} </p>
<h1>New Concern Logged</h1>
<p style="font-weight: lighter; font-size: 18px line-height: 1.6">
A new concern has been logged that requires your attention.
</p>
@component('mail::table')
| Concern             | Occurred on                | Logged by   |
| ------------------ |:------------------------- | ------------:|
|<a href="{{ route('concerns.show', ['id' => $concern->id]) }}">{{ $concern->type }}</a> |{{ $concern->concern_date }} |{{ $loggedBy }} |
@endcomponent
Regards,
<p>Concern App</p>
@endcomponent
