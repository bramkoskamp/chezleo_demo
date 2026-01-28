<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Factuur</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .invoice-details {
            text-align: right;
        }

        .invoice-details p {
            margin: 5px 0;
        }

        .client-details,
        .footer {
            margin-top: 20px;
        }

        .client-details p,
        .footer p {
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table td {
            padding: 10px;
            text-align: left;
        }

        .table th {
            border-bottom: 1px solid #ccc;
            background-color: #f2f2f2;
            padding: 10px;
            text-align: left;
        }

        .total {
            text-align: right;
            margin-top: 10px;
        }

        .total strong {
            font-size: 18px;
        }

        .price {
            text-align: right;
        }

        .orange {
            color: #FEA116;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo orange">Chez Léo</div>
            <div class="invoice-details">
                <p><strong>Rekeningnummer:</strong> {{ $reservering->id }}</p>
                <p><strong>Datum:</strong> {{ \Carbon\Carbon::parse($reservering->reservation_date)->format('d-m-Y') }}</p>
            </div>
        </div>

        <div class="client-details">
            <p><strong>Klantgegevens:</strong></p>
            <p><strong>Naam:</strong> {{ $reservering->name }}</p>
            <p><strong>Telefoonnummer:</strong> {{ $reservering->phone }}</p>
            <p><strong>Email:</strong> {{ $reservering->email }}</p>
            <p><strong>Tafelnummer:</strong> {{ $reservering->dinner_table_id }}</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Aantal</th>
                    <th>Prijs per stuk</th>
                    <th>Totaal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_price = 0;
                @endphp

                @foreach ($orders as $order)
                    @if ($order->table_number == $reservering->dinner_table_id)
                        @php
                            $grouped_items = [];
                            foreach (explode(',', $order->items) as $item) {
                                preg_match('/^(.*)\s\(([\d.]+)\)$/', trim($item), $matches);
                                $name = $matches[1] ?? $item;
                                $price = $matches[2] ?? 0;

                                if (!isset($grouped_items[$name])) {
                                    $grouped_items[$name] = ['count' => 0, 'price' => $price];
                                }
                                $grouped_items[$name]['count']++;
                            }
                        @endphp

                        @foreach ($grouped_items as $name => $details)
                            @php
                                $total_price += $details['price'] * $details['count'];
                            @endphp
                            <tr>
                                <td>{{ $name }}</td>
                                <td>{{ $details['count'] > 1 ? $details['count'] . 'x' : '1x' }}</td>
                                <td class="price">€{{ number_format($details['price'], 2, ',', '.') }}</td>
                                <td class="price">€{{ number_format($details['price'] * $details['count'], 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach

                @if ($total_price == 0)
                    <tr>
                        <td colspan="4" style="text-align: center;">Geen gegevens beschikbaar</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="total">
            <p><strong>Subtotaal:</strong> €{{ number_format($total_price * 0.91, 2, ',', '.') }}</p>
            <p><strong>BTW (9%):</strong> €{{ number_format($total_price * 0.09, 2, ',', '.') }}</p>
            <p><strong>Totaal te betalen:</strong> €{{ number_format($total_price, 2, ',', '.') }}</p>
        </div>

        <div class="footer">
            <p>Bedankt voor je bezoek aan <strong>Chez Léo</strong></p>
            <p><strong>Adres:</strong> Chez Léo, Kennedylaan 6, DoetinchemS</p>
            <p><strong>Telefoon:</strong> +012 345 67890 | <strong>E-mail:</strong> chezleo@gmail.com</p>
        </div>
    </div>
</body>

</html>
