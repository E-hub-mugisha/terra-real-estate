@component('mail::message')
# New Inquiry for Your land

Hello {{ $land->user?->name ?? 'User' }},

You have received a new inquiry for your land **{{ $land->title }}**.

**From:** {{ $data['name'] }}  
**Email:** {{ $data['email'] }}  

**Message:**  
{{ $data['message'] }}

@component('mail::button', ['url' => route('front.buy.land.details', $land)])
View land
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
