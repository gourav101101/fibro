New {{ ucfirst($enquiry->type) }} enquiry

Name: {{ $enquiry->name }}
Email: {{ $enquiry->email }}
Company: {{ $enquiry->company ?: 'Not provided' }}
Request: {{ ucfirst($enquiry->type) }}
Material: {{ $enquiry->material ?: 'Not provided' }}
Language: {{ strtoupper($enquiry->locale) }}

Requirements:
{{ $enquiry->message }}

Open in admin: {{ route('admin.enquiries.show', $enquiry) }}

Reply to this email to address {{ $enquiry->name }} directly.
