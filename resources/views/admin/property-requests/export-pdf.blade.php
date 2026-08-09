<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Property Requests Export</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #1a1a1a;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 14px;
            border-bottom: 2px solid #19265d;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 16px;
            color: #19265d;
            margin: 0;
        }

        .header p {
            margin: 2px 0 0;
            color: #6b7280;
            font-size: 9px;
        }

        .meta {
            text-align: right;
            font-size: 9px;
            color: #6b7280;
            max-width: 260px;
        }

        .meta strong {
            color: #19265d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th {
            background: #19265d;
            color: #fff;
            text-align: left;
            padding: 6px 8px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: .02em;
        }

        td {
            padding: 6px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 9px;
            vertical-align: top;
        }

        tr:nth-child(even) td {
            background: #f9fafb;
        }

        .sub {
            color: #9ca3af;
            display: block;
            margin-top: 1px;
        }

        .badge {
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
            display: inline-block;
            white-space: nowrap;
        }

        .status-new {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-in_review {
            background: #fef3c7;
            color: #92400e;
        }

        .status-matched {
            background: #dcfce7;
            color: #15803d;
        }

        .status-closed {
            background: #f3f4f6;
            color: #6b7280;
        }

        .status-unmatched {
            background: #fee2e2;
            color: #b91c1c;
        }

        .urgency-red {
            background: #fee2e2;
            color: #b91c1c;
        }

        .urgency-yellow {
            background: #fef3c7;
            color: #92400e;
        }

        .urgency-green {
            background: #dcfce7;
            color: #15803d;
        }

        .summary-bar {
            margin: 10px 0 4px;
            font-size: 9px;
            color: #374151;
        }

        .summary-bar strong {
            color: #19265d;
        }

        .empty-row {
            text-align: center;
            color: #9ca3af;
            padding: 20px 0;
        }

        .footer {
            margin-top: 16px;
            font-size: 8px;
            color: #9ca3af;
            text-align: center;
        }

        .page-number:before {
            content: counter(page);
        }
    </style>
</head>

<body>

    @php
    $labels = [
    'status' => 'Status',
    'q' => 'Search',
    'request_type' => 'Request Type',
    'property_type' => 'Property Type',
    'is_public' => 'Visibility',
    'date_range' => 'Date Range',
    'date_from' => 'From',
    'date_to' => 'To',
    ];

    $valueLabels = [
    'is_public' => ['1' => 'Public', '0' => 'Private'],
    'status' => \App\Models\PropertyRequest::STATUSES,
    'request_type' => \App\Models\PropertyRequest::REQUEST_TYPES,
    'property_type' => \App\Models\PropertyRequest::PROPERTY_TYPES,
    'date_range' => [
    'today' => 'Today',
    '7_days' => 'Last 7 Days',
    '30_days' => 'Last 30 Days',
    'this_month' => 'This Month',
    'custom' => 'Custom Range',
    ],
    ];

    $active = array_filter($filters, fn ($v) => filled($v));
    @endphp

    <div class="header">
        <div>
            <h1>Property Requests Report</h1>
            <p>{{ count($requests) }} {{ Str::plural('request', count($requests)) }} matching selected filters</p>
        </div>
        <div class="meta">
            <strong>Generated:</strong> {{ $generatedAt->format('M d, Y H:i') }}<br>
            @if(count($active))
            <strong>Filters:</strong>
            @foreach($active as $key => $value)
            {{ $labels[$key] ?? ucfirst(str_replace('_', ' ', $key)) }}:
            {{ $valueLabels[$key][$value] ?? $value }}@if(!$loop->last), @endif
            @endforeach
            @else
            <strong>Filters:</strong> None applied
            @endif
        </div>
    </div>

    <div class="summary-bar">
        <strong>Total:</strong> {{ count($requests) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Reference</th>
                <th>Client</th>
                <th>Type</th>
                <th>Budget</th>
                <th>Location</th>
                <th>Timeline</th>
                <th>Status</th>
                <th>Urgency</th>
                <th>Public</th>
                <th>Submitted</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requests as $r)
            <tr>
                <td>{{ $r->reference_number }}</td>
                <td>
                    {{ $r->full_name }}
                    <span class="sub">{{ $r->phone }}</span>
                    @if($r->email)<span class="sub">{{ $r->email }}</span>@endif
                </td>
                <td>
                    {{ \App\Models\PropertyRequest::REQUEST_TYPES[$r->request_type] ?? $r->request_type }}
                    <span class="sub">{{ $r->property_type_label }}</span>
                </td>
                <td>{{ $r->formatted_budget }}</td>
                <td>{{ $r->location_summary ?: '—' }}</td>
                <td>{{ \App\Models\PropertyRequest::TIMELINES[$r->timeline] ?? ($r->timeline ?: '—') }}</td>
                <td>
                    <span class="badge status-{{ $r->status }}">
                        {{ \App\Models\PropertyRequest::STATUSES[$r->status] ?? $r->status }}
                    </span>
                </td>
                <td>
                    <span class="badge urgency-{{ $r->urgency_badge_color }}">
                        {{ ucfirst($r->urgency) }}
                    </span>
                </td>
                <td>{{ $r->is_public ? 'Yes' : 'No' }}</td>
                <td>{{ $r->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="empty-row">No property requests found for the selected filters.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Terra &middot; Property Requests Export &middot; {{ $generatedAt->format('Y') }} &middot; Page <span class="page-number"></span>
    </div>

</body>

</html>