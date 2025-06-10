<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation d'achat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            background: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #fff;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 0 0 8px 8px;
        }
        .course-info {
            margin: 20px 0;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #4F46E5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Merci pour votre achat !</h1>
        </div>
        
        <div class="content">
            <p>Bonjour {{ $client->name }},</p>
            
            <p>Nous vous confirmons que votre achat a été effectué avec succès.</p>

            <div class="course-info">
                <h2>{{ $course->title }}</h2>
                <p><strong>Prix payé :</strong> {{ number_format($purchase->amount, 2) }} {{ strtoupper($purchase->currency) }}</p>
                <p><strong>Date d'achat :</strong> {{ $purchase->completed_at->format('d/m/Y H:i') }}</p>
                <p><strong>Numéro de commande :</strong> #{{ $purchase->id }}</p>
            </div>

            <p>Vous pouvez maintenant accéder à votre cours en vous connectant à votre compte.</p>

            <a href="{{ route('client.course.show', $course) }}" class="button">Accéder au cours</a>

            <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>

            <div class="footer">
                <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
            </div>
        </div>
    </div>
</body>
</html> 