@component('mail::message')
<p style="font-weight:lighter; font-size: 18px"> {{$user->name}} </p>
<h1>Test</h1>
<p style="font-weight: lighter; font-size: 18px line-height: 1.6">
A new concern has been logged that requires your attention.
</p>
@component('mail::table')
| Concern             | Occured on                | Logged by   |
| ------------------ |:------------------------- | ------------:|
|{{$concern->title}} |{{$concern->concern_date}} |{{$loggedBy}} |
@endcomponent
Regards,
<p>Concern App</p>
<hr>
<a href="https://www.clpt.co.uk/">CLPT</a> |
<a href="%unsubscribe_url%">Unsubscribe</a>
@endcomponent
