<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Fee Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 40px;
        }

        .header {
            text-align: center;
        }

        .logo {
            width: 200px;
            margin: auto;
            display: block;
        }

        .date {
            text-align: right;
            font-weight: bold;
        }

        .student-info {
            margin-top: 20px;
        }

        .student-info strong {
            display: inline-block;
            width: 100px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            font-style: italic;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Era International School</h2>
        <img src="logo_url_here.png" alt="School Logo" class="logo">
    </div>

    <div class="date">Date: <?php echo date('m-d-y'); ?></div>

    <div class="student-info">
        <p><strong>Name:</strong> Aarohi Dani (0698)</p>
        <p><strong>Father:</strong> Sameer Dani</p>
        <p><strong>Class:</strong> Class 2 (Bright)</p>
    </div>

    <table>
        <thead>

            <tr>
                <th>Fees Group</th>
                <th>Fees Code</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Payment Id</th>
                <th>Mode</th>
                <th>Date</th>
                <th>Paid</th>
                <th>Fine</th>
                <th>Discount</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payload as $payloadItem)
                <tr>
                    <td>{{ $payloadItem['name'] ?? '-' }}</td>
                    <td>{{ $payloadItem['code'] ?? '-' }}</td>
                    <td>{{ $payloadItem['due_date'] ?? '-' }}</td>
                    <td>{{ $payloadItem['paid'] ? 'Paid' : 'Unpaid' }}</td>
                    <td>₹{{ number_format($payloadItem['amount'] ?? 0, 2) }}</td>
                    <td>{{ $payloadItem['payment_id'] ?? '-' }}</td>
                    <td>{{ $payloadItem['mode'] ?? '-' }}</td>
                    <td>{{ $payloadItem['date'] ?? '-' }}</td>
                    <td>₹{{ number_format($payloadItem['paid'] ?? 0, 2) }}</td>
                    <td>₹{{ number_format($payloadItem['fine'] ?? 0, 2) }}</td>
                    <td>₹{{ number_format($payloadItem['discount'] ?? 0, 2) }}</td>
                    <td>₹{{ number_format($payloadItem['balance'] ?? 0, 2) }}</td>
                </tr>
            @endforeach


        </tbody>
    </table>

    <div class="footer">
        This receipt is computer generated hence no signature is required.
    </div>

    <div class="no-print">
        <button onclick="window.print()">Print Receipt</button>
    </div>

</body>

</html>
