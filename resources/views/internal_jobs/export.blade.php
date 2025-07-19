<!DOCTYPE html>
<html>

<head>
    <title>Internal Job Applicants - DMW CNC Solutions</title>
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
        </div>
        <div class="info">
            <h2>DMW CNC Solutions</h2>
            <small>Department: HR</small><br>
            <small>DOC NAME: INTERNAL JOB APPLICANTS</small>
        </div>
    </div>

    <div class="doc-title">
        Internal Job Applicants List
    </div>

    <table>
        <thead>
            <tr>
                <th>IJP ID</th>
                <th>Release Date</th>
                <th>End Date</th>
                <th>Unit</th>
                <th>Job Title</th>
                <th>Applicant</th>
                <th>Email</th>
                <th>Status</th>
                <th>Qualifications</th>
                <th>Experience</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($applications as $app)
                <tr>
                    <td>IJP - {{ $app->job->id ?? '' }}</td>
                    <td>{{ $app->job->passing_date ?? '' }}</td>
                    <td>{{ $app->job->end_date ?? '' }}</td>
                    <td>{{ $app->job->unit ?? '' }}</td>
                    <td>{{ $app->job->job_title ?? '' }}</td>
                    <td>{{ $app->user->name ?? '' }}</td>
                    <td>{{ $app->user->email ?? '' }}</td>
                    <td>{{ ucfirst($app->status ?? 'Pending') }}</td>
                    <td>{{ $app->emp_qualifications ?? '' }}</td>
                    <td>{{ $app->emp_experience ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
