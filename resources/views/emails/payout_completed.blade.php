<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry completed – Payout notification</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background: #f5f5f5; }
        .wrapper { max-width: 560px; margin: 0 auto; padding: 24px; }
        .logo { text-align: center; margin-top: 16px; }
        .logo img { max-height: 48px; }
        .card { background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); padding: 24px; margin-bottom: 16px; }
        h1 { font-size: 20px; margin: 0 0 16px; color: #1a1a1a; }
        p { margin: 0 0 12px; }
        .inquiry-id { font-weight: 600; color: #0d6efd; }
        .details { margin: 16px 0; padding: 12px 0; border-top: 1px solid #eee; border-bottom: 1px solid #eee; }
        .details p { margin: 6px 0; }
        .details-label { font-weight: 600; }
        .footer { font-size: 12px; color: #6c757d; margin-top: 24px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <p>Hi,</p>
            <p>The inquiry assigned to you has been marked as <strong>Completed</strong>, and the <strong>referral payout is pending</strong>.</p>

            <div class="details">
                <p><span class="details-label">Inquiry ID:</span> #{{ $inquiryId }}</p>
                <p><span class="details-label">Company:</span> {{ $companyName !== '' ? $companyName : '—' }}</p>
                <p><span class="details-label">Referral:</span> {{ $referralCode !== '' ? $referralCode : '—' }}</p>
            </div>

            <p>Please proceed with the referral payout and update the status in the system once the payment is completed.</p>

            <p>Thank you.</p>
            <p>Best regards,<br>{{ $senderAlias }}</p>
        </div>
        <p class="footer">This is an automated message by SQL SMS System.</p>
        <div class="logo">
            <img src="{{ asset('Logo.png') }}" alt="SQL logo">
        </div>
    </div>
</body>
</html>
