@component('mail::message')
<p style="font-weight:lighter; font-size: 18px">Hello, {{ $user->name }}</p>
<h1>New Comment Logged</h1>
<p style="font-weight: lighter; font-size: 18px; line-height: 1.6">
A new comment has been added to a concern.
</p>
@component('mail::button', ['url' => route('concerns.show', ['id' => $concern->id]), 'color' => 'success'])
View Concern
@endcomponent
Regards,
<p>Concern App</p>
@endcomponent
