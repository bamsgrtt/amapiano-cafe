<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreOperationalDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'is_open',
    ];

    protected $casts = [
        'date' => 'date',
        'is_open' => 'boolean',
    ];

    public function getStatusLabelAttribute(): string
    {
        return $this->is_open ? 'Buka' : 'Tutup';
    }

    /**
     * Group consecutive store operational dates into human-readable ranges.
     *
     * @param  \Illuminate\Support\Collection  $operationalDates
     * @return array
     */
    public static function groupAndFormatRanges($operationalDates): array
    {
        $grouped = [];
        $currentRange = null;

        foreach ($operationalDates as $item) {
            $date = \Carbon\Carbon::parse($item->date);
            
            if ($currentRange === null) {
                $currentRange = [
                    'start' => $date,
                    'end' => $date,
                    'is_open' => $item->is_open,
                    'ids' => [$item->id],
                ];
            } else {
                $prevDate = $currentRange['end'];
                
                // Check if consecutive (1 day difference) and same status
                if (abs((int) $date->diffInDays($prevDate)) === 1 && $item->is_open === $currentRange['is_open']) {
                    $currentRange['end'] = $date;
                    $currentRange['ids'][] = $item->id;
                } else {
                    $grouped[] = $currentRange;
                    $currentRange = [
                        'start' => $date,
                        'end' => $date,
                        'is_open' => $item->is_open,
                        'ids' => [$item->id],
                    ];
                }
            }
        }

        if ($currentRange !== null) {
            $grouped[] = $currentRange;
        }

        $formattedRanges = [];
        $currentYear = now()->year;
        foreach ($grouped as $range) {
            $start = $range['start'];
            $end = $range['end'];
            $showYear = ($start->year !== $currentYear || $end->year !== $currentYear);
            
            if ($start->isSameDay($end)) {
                $dateLabel = $start->translatedFormat($showYear ? 'd F Y' : 'd F');
            } elseif ($start->isSameMonth($end) && $start->isSameYear($end)) {
                $dateLabel = $start->translatedFormat('d') . ' - ' . $end->translatedFormat($showYear ? 'd F Y' : 'd F');
            } elseif ($start->isSameYear($end)) {
                $dateLabel = $start->translatedFormat('d F') . ' - ' . $end->translatedFormat($showYear ? 'd F Y' : 'd F');
            } else {
                $dateLabel = $start->translatedFormat('d F Y') . ' - ' . $end->translatedFormat('d F Y');
            }

            $diffInfo = $start->diffForHumans();

            $formattedRanges[] = (object)[
                'ids_string' => implode(',', $range['ids']),
                'date_label' => $dateLabel,
                'diff_info' => $diffInfo,
                'is_open' => $range['is_open'],
                'status_label' => $range['is_open'] ? 'Buka' : 'Tutup',
            ];
        }

        return $formattedRanges;
    }
}
