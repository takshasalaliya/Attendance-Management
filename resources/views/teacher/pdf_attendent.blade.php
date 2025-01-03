<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            margin: 20px auto;
            max-width: 90%;
        }
        .table th {
            background-color: #007bff;
            color: #fff;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<div class="table-container">
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <thead class="text-center">
                <tr>
                    <th>Enrollment Number</th>
                    <th>Name</th>
                    <th>Total Classes</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Present</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($valid as $data)
                <tr>
                    <?php
                        $sum = 0;
                        $present = 0;
                        $date = [];
                        foreach ($student as $d) {
                            if ($d->student->enrollment_number == $data && $d->staff_id == $id) {
                                $date[] = $d->created_at;
                                $sum++;
                                $name = $d->student->name;
                                
                                if ($d->attendance == 'present') {
                                    $present++;
                                }
                            }
                        }
                        sort($date);
                        $from = $date[0];
                        $from=explode(" ",$from);
                        $to = end($date);
                        $to=explode(" ",$to);
                        $percentage = number_format(($present / $sum) * 100, 2);
                    ?>
                    <td class="text-center">{{$data     }}</td>
                    <td class="text-center">{{$name}}</td>
                    <td class="text-center">{{$sum}}</td>
                    <td class="text-center">{{$from[0]}}</td>
                    <td class="text-center">{{$to[0]}}</td>
                    <td class="text-center">{{$present}}</td>
                    <td class="text-center">{{$percentage}}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
