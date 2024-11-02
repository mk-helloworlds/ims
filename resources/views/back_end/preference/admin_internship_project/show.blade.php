<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Project Name: {{ $internshipProject->project_name }}</p>
    <p>Student Name: {{ $internshipProject->student->name }}</p>
    <p>Advisor Name: {{ $internshipProject->advisor->name }}</p>

    <p>Student Name: {{ $internshipProject->student->name ?? 'No student assigned' }}</p>
    <p>Advisor Name: {{ $internshipProject->advisor->name ?? 'No advisor assigned' }}</p>
</body>
</html>