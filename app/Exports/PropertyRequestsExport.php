<?php

namespace App\Exports;

use App\Models\PropertyRequest;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PropertyRequestsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(protected Collection $requests)
    {
    }

    public function collection(): Collection
    {
        return $this->requests;
    }

    public function headings(): array
    {
        return [
            'Reference', 'Full Name', 'Phone', 'Email', 'Request Type',
            'Property Type', 'Location', 'Budget', 'Timeline', 'Urgency',
            'Status', 'Public', 'Submitted On',
        ];
    }

    public function map($r): array
    {
        return [
            $r->reference_number,
            $r->full_name,
            $r->phone,
            $r->email,
            PropertyRequest::REQUEST_TYPES[$r->request_type] ?? $r->request_type,
            $r->property_type_label,
            $r->location_summary,
            $r->formatted_budget,
            PropertyRequest::TIMELINES[$r->timeline] ?? $r->timeline,
            ucfirst($r->urgency),
            PropertyRequest::STATUSES[$r->status] ?? $r->status,
            $r->is_public ? 'Yes' : 'No',
            $r->created_at->format('Y-m-d H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => [
                'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '19265D'],
            ], 'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}