@component('mail::message')
# New Inquiry for Your Home

Hello {{ $home->user?->name ?? 'User' }},

You have received a new inquiry for your home **{{ $home->title }}**.

**From:** {{ $data['name'] }}  
**Email:** {{ $data['email'] }}  

**Message:**  
{{ $data['message'] }}

@component('mail::button', ['url' => route('front.buy.home.details', $home)])
View home
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
