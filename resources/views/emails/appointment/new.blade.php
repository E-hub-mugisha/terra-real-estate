@component('mail::message')
# New Appointment Booking

A new appointment has been booked for **{{ $consultant->name }}**.

@component('mail::table')
| Field        | Details                        |
|:-------------|:-------------------------------|
| **Client**   | {{ $appointment->name }}       |
| **Email**    | {{ $appointment->email }}      |
| **Date**     | {{ \Carbon\Carbon::parse($appointment->date)->format('D, M d Y') }} |
| **Time**     | {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}    |
| **Consultant** | {{ $consultant->name }}      |
@endcomponent

@if($appointment->message)
**Message from client:**
> {{ $appointment->message }}
@endif

@component('mail::button', ['url' => config('app.url') . '/admin/appointments'])
View in Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent