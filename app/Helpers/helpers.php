<?php

use Illuminate\Support\Facades\Request;

if (! function_exists('sort_link')) {
    function sort_link(string $col, string $label): string
    {
        $currentSort = Request::get('sort', 'due_date');
        $currentDir  = Request::get('dir', 'desc');
        $nextDir     = $currentSort === $col && $currentDir === 'asc' ? 'desc' : 'asc';
        $url         = Request::fullUrlWithQuery(['sort' => $col, 'dir' => $nextDir, 'page' => 1]);

        $arrow = '';
        if ($currentSort === $col) {
            $arrow = $currentDir === 'asc' ? ' ▲' : ' ▼';
        }

        return '<a href="' . $url . '" class="text-decoration-none">' . e($label) . $arrow . '</a>';
    }
}
