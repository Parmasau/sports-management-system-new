<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Message</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; }
        .content { padding: 30px; }
        .message-box { background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #667eea; }
        .button { display: inline-block; background: #667eea; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .footer { text-align: center; padding: 20px; color: #888; font-size: 12px; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Sports Management System</h2>
        </div>
        <div class="content">
            <h3>New Message Received!</h3>
            <p>You have received a new message from <strong>{{ $sender->name }}</strong> ({{ ucfirst($sender->role) }})</p>
            
            <div class="message-box">
                <strong>Message:</strong>
                <p style="margin-top: 10px;">{{ $message->message }}</p>
            </div>
            
            <a href="{{ url('/chat') }}" class="button">View Conversation</a>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sports Management System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
