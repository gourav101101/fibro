<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Fibro enquiry</title>
</head>
<body style="margin:0;background:#f4f5f7;color:#15233e;font-family:Arial,sans-serif">
    <div style="max-width:640px;margin:0 auto;padding:32px 16px">
        <div style="background:#fff;border:1px solid #dde2ea;border-radius:8px;overflow:hidden">
            <div style="padding:24px 28px;background:#15233e;color:#fff">
                <p style="margin:0 0 8px;font-size:13px;text-transform:uppercase">Fibro Laminates</p>
                <h1 style="margin:0;font-size:24px">New {{ ucfirst($enquiry->type) }} enquiry</h1>
            </div>
            <div style="padding:28px">
                <p style="margin:0 0 24px">A new website enquiry has been saved to the admin inbox.</p>
                <table role="presentation" style="width:100%;border-collapse:collapse">
                    <tr><th style="padding:9px 12px 9px 0;text-align:left;vertical-align:top">Name</th><td style="padding:9px 0">{{ $enquiry->name }}</td></tr>
                    <tr><th style="padding:9px 12px 9px 0;text-align:left;vertical-align:top">Email</th><td style="padding:9px 0"><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></td></tr>
                    <tr><th style="padding:9px 12px 9px 0;text-align:left;vertical-align:top">Company</th><td style="padding:9px 0">{{ $enquiry->company ?: 'Not provided' }}</td></tr>
                    <tr><th style="padding:9px 12px 9px 0;text-align:left;vertical-align:top">Request</th><td style="padding:9px 0">{{ ucfirst($enquiry->type) }}</td></tr>
                    <tr><th style="padding:9px 12px 9px 0;text-align:left;vertical-align:top">Material</th><td style="padding:9px 0">{{ $enquiry->material ?: 'Not provided' }}</td></tr>
                </table>
                <h2 style="margin:26px 0 10px;font-size:17px">Requirements</h2>
                <div style="padding:16px;background:#f4f5f7;border-radius:6px;white-space:pre-wrap;line-height:1.6">{{ $enquiry->message }}</div>
                <p style="margin:24px 0 0"><a href="{{ route('admin.enquiries.show', $enquiry) }}" style="display:inline-block;padding:12px 18px;background:#d84c3f;color:#fff;text-decoration:none;border-radius:5px">Open in admin</a></p>
                <p style="margin:18px 0 0;font-size:13px;color:#667085">Replying to this email will address {{ $enquiry->name }} directly.</p>
            </div>
        </div>
    </div>
</body>
</html>
