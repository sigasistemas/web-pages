<?php

return [
    'filament' => [
        'recordTitleAttribute' => config('filament-pages.filament.recordTitleAttribute', 'title'),
        'modelLabel' => config('filament-pages.filament.modelLabel', 'Page'),
        'pluralLabel' => config('filament-pages.filament.pluralLabel', 'Pages'),
        'navigation' => [
            'icon' => config('filament-pages.filament.navigation.icon', 'heroicon-o-document'),
            'group' => config('filament-pages.filament.navigation.group', 'Pages'),
            'sort' => config('filament-pages.filament.navigation.sort', null),
        ],
        'table' => [
            'status' => [
                'published' => 'published',
                'draft' => 'draft',
            ],
            'singular_name' => config('filament-pages.filament.table.singular_name', 'Singular name'),
            'plural_name' => config('filament-pages.filament.table.plural_name', 'Plural name'),
            'status_label' => config('filament-pages.filament.table.status', 'Status'),
            'title' => 'Title',
            'created_at' => 'Created at',
        ],
        'form' => [
            'page_group_id' => [
                'label' => 'Page group',
                'placeholder' => 'Select a page group',
            ],
            'singular_name' => [
                'label' => 'Singular name',
                'placeholder' => 'Enter the singular name',
            ],
            'plural_name' => [
                'label' => 'Plural name',
                'placeholder' => 'Enter the plural name',
            ],
            'slug' => [
                'label' => 'Slug',
                'placeholder' => 'Enter the slug (will be generated automatically if left empty)',
            ],
            'icon' => [
                'label' => 'Icon',
                'placeholder' => 'Enter the icon',
            ],
            'autheticated' => [
                'label' => 'Autheticated',
                'placeholder' => 'Enter the autheticated',
            ],
            'description' => [
                'label' => 'Description',
                'placeholder' => 'Enter the description',
            ],
            'published_at' => [
                'label' => 'Published at',
                'displayFormat' => 'd. M Y',
            ],
            'published_until' => [
                'label' => 'Published until',
                'displayFormat' => 'd. M Y',
            ],
            'ordering' => [
                'label' => 'Ordering',
            ],
            'created_at' => [
                'label' => 'Created at',
            ],
            'updated_at' => [
                'label' => 'Updated at',
            ],
            'section' => [
                'widgets' => [
                    'label' => 'Widgets',
                ],
            ],
            'widgets' => [
                'label' => 'Widgets',
                'helperText' => 'Select the widgets that will be displayed in this page',
            ],
        ],
        'widgets' => [
            'form' => [
                'name' => [
                    'label' => 'Name',
                    'placeholder' => 'Enter the name',
                ],
                'description' => [
                    'label' => 'Description',
                    'placeholder' => 'Enter the description',
                ],
                'column' => [
                    'label' => 'Columns',
                    'placeholder' => 'Enter the column',
                ],
                'ordering' => [
                    'label' => 'Ordering',
                    'placeholder' => 'Enter the ordering',
                ],
                'published_at' => [
                    'label' => 'Published at',
                    'displayFormat' => 'd. M Y',
                ],
                'published_down' => [
                    'label' => 'Published until',
                    'displayFormat' => 'd. M Y',
                ],
                'pages' => [
                    'label' => 'Pages',
                    'helperText' => 'Select the pages that will be displayed in this widget',
                ],
                'section' => [
                    'pages' => [
                        'label' => 'Pages',
                        'helperText' => 'Select the pages that will be displayed in this widget',
                    ], 
                ],
                'repeater' => [
                    'stats' => [
                        'label' => 'Stats',
                        'helperText' => 'Select the stats that will be displayed in this widget',
                        'name' => [
                            'label' => 'Name',
                            'placeholder' => 'Enter the name',
                        ],
                        'color' => [
                            'label' => 'Color',
                            'placeholder' => 'Enter the color',
                        ],
                        'icon' => [
                            'label' => 'Icon',
                            'placeholder' => 'Enter the icon',
                        ],
                        'description' => [
                            'label' => 'Description',
                            'placeholder' => 'Enter the description',
                        ],
                        'page_widget_stat_items'=>[
                            'label' => 'Items',
                            'name' => [
                                'label' => 'Name',
                                'placeholder' => 'Enter the name',
                            ], 
                            'description' => [
                                'label' => 'Description',
                                'placeholder' => 'Enter the description',
                            ],
                        ]
                    ],
                ],
            ]
        ]
    ],
];
