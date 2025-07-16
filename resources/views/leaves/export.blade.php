<!DOCTYPE html>
<html>

<head>
    <title>Leave Requests - DMW CNC Solutions</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #fc4a1a;
            padding-bottom: 5px;
        }

        .header .logo img {
            height: 50px;
        }

        .header .info {
            text-align: right;
        }

        .info h2 {
            margin: 0;
            font-size: 16px;
            color: #fc4a1a;
        }

        .info small {
            font-size: 10px;
            color: #666;
        }

        .doc-title {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th {
            background-color: #f7b733;
            color: white;
            padding: 6px;
            border: 1px solid #ddd;
            text-align: center;
        }

        td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/logo.png') }}" alt="DMW CNC Solutions Logo">
            {{-- Replace 'images/logo.png' with actual path --}}
        </div>
        <div class="info">
            <h2>DMW CNC Solutions</h2>
            <small>Department: HR</small><br>
            <small>DOC NAME: LEAVE REQUEST</small>
        </div>
    </div>

    <div class="doc-title">
        Leave Requests List
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Employee</th>
                <th>Leave Type</th>
                <th>From</th>
                <th>To</th>
                <th>Days</th>
                <th>Approver 1</th>
                <th>Approver 2</th>
                <th>Status</th>
                <th>Applied On</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leaves as $index => $leave)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $leave->user->name ?? 'Unknown' }}</td>
                    <td>{{ ucfirst($leave->leave_type) }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->from_date)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->to_date)->format('d-m-Y') }}</td>
                    <td>{{ $leave->leave_days }}</td>
                    <td>{{ optional($leave->approver1)->name ?? '-' }}</td>
                    <td>{{ optional($leave->approver2)->name ?? '-' }}</td>
                    <td>{{ strtoupper($leave->status) }}</td>
                    <td>{{ $leave->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
