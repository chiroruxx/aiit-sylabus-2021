<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Syllabus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SyllabusService
{
    public function list(array $params): Collection
    {
        /** @var Syllabus $syllabiQuery */
        $syllabiQuery = Syllabus::orderBy('course')->orderBy('name_ja');

        if (isset($params['courses']) && count($params['courses']) > 0) {
            $syllabiQuery = $syllabiQuery->whereIn('course', $params['courses']);
        }
        if (isset($params['quarters']) && count($params['quarters']) > 0) {
            $syllabiQuery = $syllabiQuery->whereIn('quarter', $params['quarters']);
        }
        if (isset($params['model']['types']) && count($params['model']['types']) > 0) {
            $syllabiQuery = $syllabiQuery->whereHas('models', function (Builder $query) use($params): void {
                $query->whereIn('type', $params['model']['types']);
            });
        }

        return $syllabiQuery->get();
    }
}
