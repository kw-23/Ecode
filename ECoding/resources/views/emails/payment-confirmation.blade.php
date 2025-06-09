<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #6366f1;
        }
        .header h1 {
            color: #6366f1;
            margin: 0;
            font-size: 28px;
        }
        .success-icon {
            width: 60px;
            height: 60px;
            background: #10b981;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .success-icon svg {
            width: 30px;
            height: 30px;
            color: white;
        }
        .course-details {
            background: #f8fafc;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #6366f1;
        }
        .course-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 10px;
        }
        .course-info {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        .course-info span {
            color: #64748b;
        }
        .course-info strong {
            color: #1e293b;
        }
        .payment-details {
            background: #f0f9ff;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .payment-details h3 {
            color: #0369a1;
            margin-top: 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .detail-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 18px;
            color: #6366f1;
        }
        .cta-section {
            text-align: center;
            margin: 30px 0;
        }
        .cta-button {
            display: inline-block;
            background: #6366f1;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 10px;
        }
        .cta-button:hover {
            background: #4f46e5;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 14px;
        }
        .footer a {
            color: #6366f1;
            text-decoration: none;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .email-container {
                padding: 20px;
            }
            .course-info {
                flex-direction: column;
            }
            .detail-row {
                flex-direction: column;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="success-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1>Payment Confirmed!</h1>
            <p>Thank you for your purchase, {{ $client->name }}!</p>
        </div>

        <div class="course-details">
            <div class="course-title">{{ $course->title }}</div>
            <div class="course-info">
                <span>Instructor:</span>
                <strong>{{ $course->instructor->name ?? 'N/A' }}</strong>
            </div>
            <div class="course-info">
                <span>Purchase Date:</span>
                <strong>{{ $purchase->completed_at->format('F j, Y \a\t g:i A') }}</strong>
            </div>
            <div class="course-info">
                <span>Order ID:</span>
                <strong>#{{ $purchase->id }}</strong>
            </div>
        </div>

        <div class="payment-details">
            <h3>Payment Details</h3>
            <div class="detail-row">
                <span>Course Price:</span>
                <span>${{ number_format($purchase->amount, 2) }}</span>
            </div>
            <div class="detail-row">
                <span>Payment Method:</span>
                <span>{{ ucfirst($purchase->payment_method) }}</span>
            </div>
            <div class="detail-row">
                <span>Transaction ID:</span>
                <span>{{ $purchase->payment_intent_id }}</span>
            </div>
            <div class="detail-row">
                <span>Total Paid:</span>
                <span>${{ number_format($purchase->amount, 2) }}</span>
            </div>
        </div>

        <div class="cta-section">
            <p>Your course is now available in your dashboard!</p>
            <a href="{{ route('client.course.show', $course) }}" class="cta-button">
                Start Learning
            </a>
            <a href="{{ route('client.dashboard') }}" class="cta-button" style="background: #64748b;">
                View Dashboard
            </a>
        </div>

        <div class="footer">
            <p>
                If you have any questions about your purchase, please contact our support team at 
                <a href="mailto:support@yoursite.com">support@yoursite.com</a>
            </p>
            <p>
                <a href="{{ route('payment.invoice', $purchase) }}">Download Invoice</a> | 
                <a href="{{ route('client.dashboard') }}">My Courses</a>
            </p>
            <p>&copy; {{ date('Y') }} Your Learning Platform. All rights reserved.</p>
        </div>
    </div>
</body>
</html>