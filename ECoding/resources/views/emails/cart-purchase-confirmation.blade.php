<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Confirmation</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #ffffff;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .course-list {
            margin: 20px 0;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }
        .course-item {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .course-item:last-child {
            border-bottom: none;
        }
        .course-title {
            font-weight: 600;
            color: #2d3748;
            margin: 0;
        }
        .course-price {
            font-weight: 600;
            color: #4a5568;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
        }
        .total-label {
            font-weight: 600;
            color: #4a5568;
        }
        .total-amount {
            font-size: 1.2em;
            font-weight: 700;
            color: #2d3748;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #6366f1;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #718096;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Your Purchase!</h1>
            <p>Your courses are ready to access</p>
        </div>
        
        <div class="content">
            <p>Dear {{ $client->name }},</p>
            
            <p>Thank you for your purchase! We're excited to have you join our learning community. Here's a summary of your purchase:</p>

            <div class="course-list">
                @foreach($purchases as $purchase)
                    <div class="course-item">
                        <div>
                            <h3 class="course-title">{{ $purchase->course->title }}</h3>
                            @if($purchase->course->instructor)
                                <p style="color: #718096; margin: 5px 0;">By {{ $purchase->course->instructor->name }}</p>
                            @endif
                        </div>
                        <div class="course-price">${{ number_format($purchase->amount, 2) }}</div>
                    </div>
                @endforeach
            </div>

            <div class="total">
                <span class="total-label">Total Amount:</span>
                <span class="total-amount">${{ number_format($totalAmount, 2) }}</span>
            </div>

            <p>You can access your courses immediately by logging into your account:</p>
            
            <div style="text-align: center;">
                <a href="{{ route('client.dashboard') }}" class="button">Go to My Courses</a>
            </div>

            <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

            <div class="footer">
                <p>Thank you for choosing our platform for your learning journey!</p>
                <p>Best regards,<br>The ECoding Team</p>
            </div>
        </div>
    </div>
</body>
</html> 