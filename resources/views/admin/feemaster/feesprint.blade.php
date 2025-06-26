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

    <div class="date">Date: <?php echo date('d-m-y'); ?> <br />
        @foreach ($deposits as $payloadItem)
            <td>{{ $payloadItem['description'] ?? '-' }}</td>
        @endforeach
    </div>


    <div class="student-info">

        @foreach ($student_details as $payloadItem)
            <p><strong>Name:</strong> {{ $payloadItem['firstname'] ?? '-' }} {{ $payloadItem['lastname'] ?? '-' }} -
                {{ $payloadItem['admission_no'] ?? '(' . $payloadItem['admission_no'] . ')' }}</p>
            <p><strong>Father:</strong> {{ $payloadItem['father_name'] ?? '-' }}</p>
            <p><strong>Class:</strong> {{ $payloadItem['class_name'] ?? '-' }} {{ $payloadItem['section_name'] ?? '-' }}
            </p>
        @endforeach

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
                    @foreach ($deposits as $payloadItem)
                        <td>{{ $payloadItem['amount'] ?? '-' }}</td>
                        <td>{{ $payloadItem['payment_mode'] ?? '-' }}</td>
                        <td>{{ $payloadItem['date'] ?? '-' }}</td>
                    @endforeach

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
