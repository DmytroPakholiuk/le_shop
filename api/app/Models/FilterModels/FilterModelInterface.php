<?php

namespace App\Models\FilterModels;

/**
 * This interface is here to grant the FilterModel classes a common type
 */
interface FilterModelInterface
{
    public function filterRules(): array;

    public function search();
}
