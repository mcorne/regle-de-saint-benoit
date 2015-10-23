<?php
/**
 * Règle de saint Benoît
 *
 * Command line to publish chapters
 *
 * @author    Michel Corne <mcorne@yahoo.com>
 * @copyright 2014 Michel Corne
 * @license   http://www.opensource.org/licenses/gpl-3.0.html GNU GPL v3
 * @link      http://regle-de-saint-benoit.blogspot.fr/
 */

require_once 'Blog.php';
require_once 'Text.php';

// TODO: finish

/**
 * The command help
 */
$help =
'Usage:
-c              Update the copyright widget with the current year.
-n number       Optional comma separated list of numbers of fables.
                By default, all fables are processed.
                Mandatory in logged off mode, only one number allowed.
-p password     Blogger account Password.
-u name         Blogger user/email/login name.

Notes:
In logged on mode, the fable HTML is created/updated in the data directory.
In logged off mode, the fable HTML is stored in data/temp.html.

Examples:
# publish fable(s) in Blogger
publish -u abc -p xyz

# publish fables 10 and 11 in Blogger
publish -u abc -p xyz -n 10,11

# create/update fable 10 in data/temp.html
publish -n 10
';

$blog = (isset($argv[1]) and isset($argv[2]))?
    new Blog($argv[1], $argv[2], 'La règle de saint Benoit') : null;
$text = new Text($blog);
$text->makeMessages();
