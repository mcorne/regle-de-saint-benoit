#!/usr/bin/php
<?php
/**
 * Règle de saint Benoît
 *
 * Command line to publish chapters
 *
 * @author    Michel Corne <mcorne@yahoo.com>
 * @copyright 2016 Michel Corne
 * @license   http://www.opensource.org/licenses/gpl-3.0.html GNU GPL v3
 * @link      https://regle-de-saint-benoit.blogspot.fr/
 */

require_once 'Blog.php';
require_once 'Text.php';

/**
 * The command help
 */
$help =
'Usage:
-n number,...   Optional comma separated list of numbers of chapters.
                By default, all chapters are processed.
                Mandatory in logged off mode, only one number allowed.
                999 is the number of the chapter being translated.
-p password     Blogger account Password.
-u name         Blogger user/email/login name.
-v              Verification mode only: no publishing, no file changes.

Notes:
In logged on mode, the chapter HTML is created/updated in the messages directory.
In logged off mode, the chapter HTML is stored in messages/temp.html.

You need to be authorized to be able to publish.
Run "authorize -h" for more information.

Examples:
# publish chapter(s) in Blogger
publish -u abc -p xyz

# publish chapters 10 and 11 in Blogger
publish -u abc -p xyz -n 10,11

# create/update chapter 10 in messages/temp.html
publish -n 10

# list the chapters that have changed and need to be published
publish -v
';

try {
    if (! $options = getopt("hn:p:u:v")) {
        throw new Exception('invalid or missing option(s)');
    }

    if (isset($options['h'])) {
        // displays the command usage (help)
        exit($help);
    }

    $text = new Text();
    list($frenchChapters, $latinChapters) = $text->parseFiles();

    if ($verification_only = isset($options['v'])) {
        // this is the verification mode, there will be no publishing and no file changes
        if (isset($options['n'])) {
            $numbers = explode(',', $options['n']);
            $flipped_numbers = array_flip($numbers);
            $frenchChapters = array_intersect_key($frenchChapters, $flipped_numbers);
            $latinChapters = array_intersect_key($latinChapters, $flipped_numbers);
        }

        $htmls = array_map(array($text, 'makeMessage'), $frenchChapters, $latinChapters, $numbers);
        echo "\n" . $text->saveMessages($htmls, $frenchChapters) . "\n";
    } elseif (isset($options['u']) and isset($options['p'])) {
        // this is the logged on mode, publishes one more chapters in Blogger and saves them in local files
        if (isset($options['n'])) {
            $numbers = explode(',', $options['n']);
            $flipped_numbers = array_flip($numbers);
            $frenchChapters = array_intersect_key($frenchChapters, $flipped_numbers);
            $latinChapters = array_intersect_key($latinChapters, $flipped_numbers);
        }

        $htmls = array_map(array($text, 'makeMessage'), $frenchChapters, $latinChapters, $numbers);
        $blog = new Blog($options['u'], $options['p']);
        echo "\n" . $text->saveMessages($htmls, $frenchChapters, $blog) . "\n";
    } elseif (isset($options['u']) or isset($options['p'])) {
        throw new Exception('missing user name or password');
    }

    if (isset($options['n'])) {
        // this is the logged off mode, makes an chapter HTML and saves the content in messages/temp.html
        $number = $options['n'];

        if (! isset($frenchChapters[$number])) {
            throw new Exception('invalid chapter number');
        }

        $html = $text->makeMessage($frenchChapters[$number], $latinChapters[$number], $number);
        echo "\n" . $text->saveTempMessage($html, $number) . "\n";
    }
} catch (Exception $e) {
    echo($e->getMessage());
}
