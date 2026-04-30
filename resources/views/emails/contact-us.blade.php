<x-mail::message>
# New Message from Website Contact Form

**Name:** {{ $data['name'] }}  
**Email:** {{ $data['email'] }}  
**Subject:** {{ $data['subject'] }}

**Message:**  
{{ $data['message'] }}

Thanks,  
{{ config('app.name') }}
</x-mail::message>
