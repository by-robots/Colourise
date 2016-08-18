<?php

return [
    /**
     * Name of the app.
     *
     * @var string
     */
    'name' => 'Colourise',

    /**
     * Path to store originals.
     *
     * @var string
     */
    'original-path' => storage_path() . '/images/original',

    /**
     * Path to store the colourised photos.
     *
     * @var string
     */
    'colourised-path' => storage_path() . '/images/colourised',

    /**
     * The archive path.
     *
     * @var string
     */
    'archive-path' => storage_path() . '/archives',
];
