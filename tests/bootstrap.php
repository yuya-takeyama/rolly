<?php
/*
 * This file is part of Rolly.
 *
 * (c) Yuya Takeyama <sign.of.the.wolf.pentagram@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
set_include_path(
    dirname(__FILE__) . '/../src' . PATH_SEPARATOR .
    dirname(__FILE__) . PATH_SEPARATOR .
    get_include_path()
);
ini_set('error_reporting', E_ALL);
