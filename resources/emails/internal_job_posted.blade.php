<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Internal Job Posted</title>
</head>
<body>
    <h2>Hello {{ $user->name }},</h2>

    <p>A new internal job opportunity has been posted:</p>

    <ul>
        <li><strong>Title:</strong> {{ $job->job_title }}</li>
        <li><strong>Division:</strong> {{ $job->division }}</li>
        <li><strong>Unit:</strong> {{ $job->unit }}</li>
        <li><strong>Slots Available:</strong> {{ $job->slot_available }}</li>
        <li><strong>End Date:</strong> {{ $job->end_date }}</li>
    </ul>

    <p>Please visit the internal job portal to apply if you're interested.</p>

    <p>Regards,<br>HR Team</p>
</body>
</html>
