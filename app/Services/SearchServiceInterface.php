<?php

namespace App\Services;

interface SearchServiceInterface
{
    /**
     * Runs a search against the listings and returns:
     * [
     *     'filters' => array,   // extracted/parsed filters
     *     'summary' => string,  // human-readable summary of what was searched
     *     'results' => array,   // ['houses' => Collection, 'lands' => Collection, ...]
     *     'total'   => int,     // sum of all result counts
     * ]
     */
    public function search(string $query): array;
}
