@php
    use Carbon\Carbon;

    // Formatteer de datum
    $formattedDate = Carbon::createFromFormat('Y-m-d', $reservering['reservation_date'])->translatedFormat('l d F');

    // Bereken de begintijd en eindtijd
    $startTime = Carbon::createFromFormat('H:i', $reservering['reservation_time']);
    $endTime = $startTime->copy()->addHours(3);
@endphp

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bevestiging van Aanmelding</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f8f9fa; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; padding: 20px; border: 1px solid #e0e0e0;">
        <h1 style="color: #343a40; text-align: center;">Aanmeldingsbevestiging</h1>

        <p style="color: #555;">Beste {{ $reservering['name'] }},</p>

        <p style="color: #555;">Je hebt gereserveerd voor <strong>{{ $formattedDate }}</strong>.</p>

        <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px; border: 1px solid #e0e0e0; color: #343a40;"><strong>Begintijd:</strong></td>
                <td style="padding: 10px; border: 1px solid #e0e0e0; color: #555;">{{ $startTime->format('H:i') }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #e0e0e0; color: #343a40;"><strong>Eindtijd:</strong></td>
                <td style="padding: 10px; border: 1px solid #e0e0e0; color: #555;">{{ $endTime->format('H:i') }}</td>
            </tr>
        </table>

        <p style="color: #555;">Als u vragen heeft of verdere hulp nodig heeft, neem dan gerust contact met ons op.</p>

        <p style="color: #555;">We kijken ernaar uit om u te verwelkomen!</p>

        <p style="color: #555; text-align: center;">
            <a href="http://chezleo.test/register" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px; text-align: center;">Aanmelden</a>
        </p>

        <p style="color: #555;">Met vriendelijke groet,<br>Chezleo</p>
    </div>
</body>
</html>
