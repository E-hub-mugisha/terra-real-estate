@component('mail::message')
# New Inquiry for Your Design

Hello {{ $design->user?->name ?? 'Designer' }},

You have received a new inquiry for your architectural design **{{ $design->title }}**.

**From:** {{ $data['name'] }}  
**Email:** {{ $data['email'] }}  

**Message:**  
{{ $data['message'] }}

@component('mail::button', ['url' => route('front.buy.design.purchase', $design->slug)])
View Design
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
