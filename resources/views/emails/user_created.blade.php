@component('mail::message')
# Welcome to Our Platform

Hi {{ $user->name }},

Your account has been successfully created. Here are your account details:

- Name: {{ $user->name }}
- Username: {{ $user->username }}
- Email: {{ $user->email }}
- Password: {{ $undecryptedPassword }}

Thank you for joining us!

@endcomponent
