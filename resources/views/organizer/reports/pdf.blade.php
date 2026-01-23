<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $event->name }} - Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #D4AF37;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #D4AF37;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .stat-box {
            display: table-cell;
            width: 33.33%;
            padding: 15px;
            text-align: center;
            background: #f8f9fa;
            border: 1px solid #ddd;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #D4AF37;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: #D4AF37;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            color: #D4AF37;
            border-bottom: 2px solid #D4AF37;
            padding-bottom: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $event->name }}</h1>
        <p>Event Report - Generated on {{ now()->format('M d, Y H:i') }}</p>
        <p>{{ $event->start_date->format('M d, Y') }} - {{ $event->end_date->format('M d, Y') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="stat-label">Total Votes</div>
            <div class="stat-value">{{ number_format($totalVotes) }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">₦{{ number_format($totalRevenue, 2) }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Contestants</div>
            <div class="stat-value">{{ $contestants->count() }}</div>
        </div>
    </div>

    <div class="section-title">Top Contestants</div>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Category</th>
                <th>Total Votes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contestants->take(20) as $index => $contestant)
                <tr>
                    <td>#{{ $index + 1 }}</td>
                    <td>{{ $contestant->name }}</td>
                    <td>{{ $contestant->category->name ?? 'N/A' }}</td>
                    <td>{{ number_format($contestant->total_votes) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Recent Votes</div>
    <table>
        <thead>
            <tr>
                <th>Voter Email</th>
                <th>Contestant</th>
                <th>Vote Count</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($votes->take(50) as $vote)
                <tr>
                    <td>{{ $vote->voter_email }}</td>
                    <td>{{ $vote->contestant->name ?? 'N/A' }}</td>
                    <td>{{ $vote->vote_count }}</td>
                    <td>₦{{ number_format($vote->amount_paid, 2) }}</td>
                    <td>{{ $vote->created_at->format('M d, Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This is an automatically generated report from VoteAfrica Platform</p>
        <p>© {{ now()->year }} VoteAfrica. All rights reserved.</p>
    </div>
</body>
</html>