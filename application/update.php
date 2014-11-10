<?php
/**
 * Règle de saint Benoît
 *
 * Update rule entries
 *
 * @author    Michel Corne <mcorne@yahoo.com>
 * @copyright 2014 Michel Corne
 * @license   http://www.opensource.org/licenses/gpl-3.0.html GNU GPL v3
 * @link      http://regle-de-saint-benoit.blogspot.fr/
 */

require 'Text.php';

$blog = (isset($argv[1]) and isset($argv[2]))?
    new Blog($argv[1], $argv[2], 'La règle de saint Benoit') : null;
$text = new Text($blog);
$text->makeMessages();
