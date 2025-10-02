<?php

return [
    'exports' => [
        'chunk_size' => 1000,
        'pre_calculate_formulas' => false,
        'strict_null_comparison' => false,
        'csv' => [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => PHP_EOL,
            'use_bom' => false,
            'include_separator_line' => false,
            'excel_compatibility' => false,
            'output_encoding' => '',
        ],
        'properties' => [
            'creator' => 'Maatwebsite',
            'lastModifiedBy' => 'Maatwebsite',
            'title' => 'Attendance Export',
            'description' => 'Attendance System Export',
            'subject' => 'Attendances',
            'keywords' => 'attendance,export,excel',
            'category' => 'Attendances',
            'manager' => 'Maatwebsite',
            'company' => 'Maatwebsite',
        ],
    ],
];