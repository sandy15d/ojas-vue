<?php

// config/cogs.php

return [
    /*
    |--------------------------------------------------------------------------
    | COGS Database Connection
    |--------------------------------------------------------------------------
    |
    | This option defines the database connection that should be used for all
    | COGS and Analysis related operations. This can be set to 'ojas_cogs',
    | 'ojas_cogs_it', or any other connection defined in config/database.php
    |
    */
    'database_connection' => env('COGS_DB_CONNECTION', 'ojas_cogs'),

    /*
    |--------------------------------------------------------------------------
    | Default Configuration
    |--------------------------------------------------------------------------
    */
    'default_year' => env('COGS_DEFAULT_YEAR', '2024-25'),
    'default_level' => env('COGS_DEFAULT_LEVEL', 'company_level'),
    'default_coded' => env('COGS_DEFAULT_CODED', 'Y'),

    /*
    |--------------------------------------------------------------------------
    | Calculator Class Mapping
    |--------------------------------------------------------------------------
    |
    | This array maps calculator types to their corresponding service classes
    | for COGS calculations across different categories.
    |
    */
    'calculator_mapping' => [
        'sales' => \App\Services\Cogs\Calculators\SalesCalculator::class,
        'raw_material' => \App\Services\Cogs\Calculators\RawMaterialCalculator::class,
        'conditioned' => \App\Services\Cogs\Calculators\ConditionedMaterialCalculator::class,
        'packing' => \App\Services\Cogs\Calculators\PackingCalculator::class,
        'sub_standard' => \App\Services\Cogs\Calculators\SubStandardCalculator::class,
        'associated_cost' => \App\Services\Cogs\Calculators\AssociatedCostCalculator::class,
        'summary' => \App\Services\Cogs\Calculators\SummaryCalculator::class,
    ],
];
