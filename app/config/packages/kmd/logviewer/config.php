<?php

return array(
    
    'base_url'   => 'log-view',
    'filters'    => array(
        'global' => array(
            'before' => 'admin-auth'
            ),
        'view'   => array(),
        'delete' => array(),
    ),
    'log_dirs'   => array('app' => storage_path().'/logs'),
    'log_order'  => 'desc', // Change to 'desc' for the latest entries first
    'per_page'   => 10,
    'view'       => 'logviewer::viewer',
    'p_view'     => 'pagination::slider',

);
