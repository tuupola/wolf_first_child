<?php

/*
 * First Child - Frog CMS behaviour
 *
 * Copyright (c) 2009 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/
 */

Plugin::setInfos(array(
    'id'          => 'first_child',
    'title'       => 'First Child', 
    'description' => 'Redirects page to its first child.', 
    'version'     => '0.1.2',
    'license'     => 'MIT',
    'author'      => 'Mika Tuupola',
    'update_url'  => 'http://www.appelsiini.net/download/frog-plugins.xml',
    'website'     => 'http://www.appelsiini.net/'
));

Behavior::add('Redirect_to_first_child', 'first_child/first_child.php');
