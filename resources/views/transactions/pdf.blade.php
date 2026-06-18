<!DOCTYPE html>
<html>
<head>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Transaction Report</h2>
    <table>
        <thead><tr><th>Title</th><th>Amount</th><th>Date</th></tr></thead>
        <tbody>
            @foreach($transactions as $t)
            <tr><td>{{ $t->title }}</td><td>{{ $t->amount }}</td><td>{{ $t->created_at }}</td></tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>