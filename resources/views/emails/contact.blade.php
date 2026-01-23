<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact Form Submission</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background: #f8f9fa;">
        <div style="background: white; padding: 30px; border-radius: 10px;">
            <h2 style="color: #D4AF37; margin-top: 0;">New Contact Form Submission</h2>
            
            <p><strong>From:</strong> {{ $name }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
            
            <div style="margin-top: 20px; padding: 20px; background: #f8f9fa; border-left: 4px solid #D4AF37; border-radius: 5px;">
                <p style="margin: 0;"><strong>Message:</strong></p>
                <p style="margin-top: 10px;">{{ $message }}</p>
            </div>
            
            <p style="margin-top: 30px; font-size: 12px; color: #666;">
                This email was sent from the VoteAfrica contact form.
            </p>
        </div>
    </div>
</body>
</html>