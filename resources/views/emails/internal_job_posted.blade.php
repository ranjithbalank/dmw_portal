<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-wrapper {
            max-width: 640px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #004080;
            padding: 20px;
            text-align: center;
            color: #fff;
        }
        .header img {
            max-height: 50px;
            margin-bottom: 10px;
        }
        .job-card {
            background-color: #fff;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            margin-top: 20px;
        }
        .job-title {
            font-size: 22px;
            color: #004080;
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
        }
        .apply-btn {
            display: inline-block;
            background-color: #28a745;
            color: #fff !important;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            font-size: 12px;
            color: #888;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            {{-- Replace with your logo --}}
            <img src="https://www.dmwindia.com/wp-content/uploads/2018/04/logo.png" alt="Company Logo">
            <h2>Internal Job Opportunities</h2>
        </div>

        <div class="job-card">
            <div class="job-title">New Job Opening: {{ $job->job_title }}</div>

            <p>{{ $job->job_description }}</p>

            @if(!empty($job->unit))
                <p><span class="label">Unit:</span> {{ $job->unit }}</p>
            @endif

            @if(!empty($job->division))
                <p><span class="label">Division:</span> {{ $job->division }}</p>
            @endif

            @if(!empty($job->location))
                <p><span class="label">Location:</span> {{ $job->location }}</p>
            @endif

            <p><span class="label">Apply before:</span> {{ \Carbon\Carbon::parse($job->end_date)->format('F j, Y') }}</p>

            @if(!empty($job->application_link))
                <a href="{{ $job->application_link }}" class="apply-btn" target="_blank">Apply Now</a>
            @endif
        </div>

        <div class="footer">
            You’re receiving this email because you subscribed to job alerts. If you wish to unsubscribe, contact HR.
        </div>
    </div>
</body>
</html>
