<?php
/**
 * Règle de saint Benoît
 *
 * Processing of chapters
 *
 * @author    Michel Corne <mcorne@yahoo.com>
 * @copyright 2016 Michel Corne
 * @license   http://www.opensource.org/licenses/gpl-3.0.html GNU GPL v3
 * @link      https://regle-de-saint-benoit.blogspot.fr/
 */

require 'Blog.php';

class Text
{
    const SPECIAL_CHAR = '€';

    public $blog;
    public $images;
    public $prevChapter;
    public $prevLine;
    public $prevNote;

    /**
     *
     * @var array
     */
    public $bible = array(
        'Actes',
        'Apocalypse',
        'Colossiens',
        '1 Corinthiens',
        '2 Corinthiens',
        'Daniel',
        // 'Dialogues',
        'Éphésiens',
        'Exode',
        'Ezéchiel',
        'Galates',
        'Genèse',
        'Hébreux',
        'Ésaïe',
        'Jean',
        '1 Jean',
        'Jude',
        'Judith',
        'Lettre de Jérémie',
        'Luc',
        'Marc',
        'Matthieu',
        'Philémon',
        '1 Pierre',
        'Proverbes',
        'Psaumes',
        'Romains',
        '1 Samuel',
        // 'Sermon',
        'Siracide',
        '1 Thessaloniciens',
        '1 Timothée',
        '2 Timothée',
        'Tite',
        'Tobit',
    );

    /**
     *
     * @var array
     */
    public $images = array(
        '0006' => '-f. 4r-',
        '0007' => '-f. 4v-',
        '0008' => '-f. 5r-',
        '0009' => '-f. 5v-',
        '0010' => '-f. 6r-',
        '0011' => '-f. 6v-',
        '0012' => '-f. 7r-',
        '0013' => '-f. 7v-',
        '0014' => '-f. 8r-',
        '0015' => '-f. 8v-',
        '0016' => '-f. 9r-',
        '0017' => '-f. 9v-',
        '0018' => '-f. 10r-',
        '0019' => '-f. 10v-',
        '0020' => '-f. 11r-',
        '0021' => '-f. 11v-',
        '0022' => '-f. 12r-',
        '0023' => '-f. 12v-',
        '0024' => '-f. 13r-',
        '0025' => '-f. 13v-',
        '0026' => '-f. 13(b)r-',
        '0027' => '-f. 13(b)v-',
        '0028' => '-f. 14r-',
        '0029' => '-f. 14v-',
        '0030' => '-f. 15r-',
        '0031' => '-f. 15v-',
        '0032' => '-f. 16r-',
        '0033' => '-f. 16v-',
        '0034' => '-f. 17r-',
        '0035' => '-f. 17v-',
        '0036' => '-f. 18r-',
        '0037' => '-f. 18v-',
        '0038' => '-f. 19r-',
        '0039' => '-f. 19v-',
        '0040' => '-f. 20r-',
        '0041' => '-f. 20v-',
        '0042' => '-f. 21r-',
        '0043' => '-f. 21v-',
        '0044' => '-f. 22r-',
        '0045' => '-f. 22v-',
        '0046' => '-f. 23r-',
        '0047' => '-f. 23v-',
        '0048' => '-f. 24r-',
        '0049' => '-f. 24v-',
        '0050' => '-f. 25r-',
        '0051' => '-f. 25v-',
        '0052' => '-f. 26r-',
        '0053' => '-f. 26v-',
        '0054' => '-f. 27r-',
        '0055' => '-f. 27v-',
        '0056' => '-f. 28r-',
        '0057' => '-f. 28v-',
        '0058' => '-f. 29r-',
        '0059' => '-f. 29v-',
        '0060' => '-f. 30r-',
        '0061' => '-f. 30v-',
        '0062' => '-f. 31r-',
        '0063' => '-f. 31v-',
        '0064' => '-f. 32r-',
        '0065' => '-f. 32v-',
        '0066' => '-f. 33r-',
        '0067' => '-f. 33v-',
        '0068' => '-f. 34r-',
        '0069' => '-f. 34v-',
        '0070' => '-f. 35r-',
        '0071' => '-f. 35v-',
        '0072' => '-f. 36r-',
        '0073' => '-f. 36v-',
        '0074' => '-f. 37r-',
        '0075' => '-f. 37v-',
        '0076' => '-f. 38r-',
        '0077' => '-f. 38v-',
        '0078' => '-f. 39r-',
        '0079' => '-f. 39v-',
        '0080' => '-f. 40r-',
        '0081' => '-f. 40v-',
        '0082' => '-f. 41r-',
        '0083' => '-f. 41v-',
    );

    /**
     *
     * @var array
     */
    public $romanNumbers = array(
        '0', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX',
        'X', 'XI', 'XII', 'XIII', 'XIV', 'XV', 'XVI', 'XVII', 'XVIII', 'XIX',
        'XX', 'XXI', 'XXII', 'XXIII', 'XXIV', 'XXV', 'XXVI', 'XXVII', 'XXVIII', 'XXIX',
        'XXX', 'XXXI', 'XXXII', 'XXXIII', 'XXXIV', 'XXXV', 'XXXVI', 'XXXVII', 'XXXVIII', 'XXXIX',
        'XL', 'XLI', 'XLII', 'XLIII', 'XLIV', 'XLV', 'XLVI', 'XLVII', 'XLVIII', 'XLIX',
        'L', 'LI', 'LII', 'LIII', 'LIV', 'LV', 'LVI', 'LVII', 'LVIII', 'LIX',
        'LX', 'LXI', 'LXII', 'LXIII', 'LXIV', 'LXV', 'LXVI', 'LXVII', 'LXVIII', 'LXIX',
        'LXX', 'LXXI', 'LXXII', 'LXXIII',
    );

    /**
     *
     * @var array
     */
    public $urls = array(
        0 => '/2011/08/prologue.html',
        1 => '/2011/08/les-categories-de-moines.html',
        2 => '/2011/08/les-qualites-que-doit-avoir-labbe.html',
        3 => '/2011/08/lappel-des-freres-en-conseil.html',
        4 => '/2011/08/les-instruments-des-bonnes-oeuvres.html',
        5 => '/2011/08/lobeissance.html',
        6 => '/2011/08/la-retenue-dans-le-langage.html',
        7 => '/2011/08/lhumilite.html',
        8 => '/2011/08/les-offices-divins-dans-la-nuit.html',
        9 => '/2011/08/combien-il-faut-dire-de-psaumes-aux.html',
        10 => '/2011/08/comment-celebrer-en-ete-la-louange.html',
        11 => '/2011/08/comment-celebrer-les-vigiles-le.html',
        12 => '/2011/08/comment-celebrer-la-solennite-des.html',
        13 => '/2011/08/comment-celebrer-les-laudes-aux-jours.html',
        14 => '/2011/08/comment-celebrer-les-vigiles-aux-fetes.html',
        15 => '/2011/08/quand-dire-lalleluia.html',
        16 => '/2011/08/comment-celebrer-les-divins-offices.html',
        17 => '/2011/08/combien-de-psaumes-il-faut-dire-ces.html',
        18 => '/2011/08/en-quel-ordre-il-faut-dire-les-psaumes.html',
        19 => '/2011/08/le-maintien-pendant-la-psalmodie.html',
        20 => '/2011/08/la-reverence-dans-la-priere.html',
        21 => '/2011/08/les-doyens-du-monastere.html',
        22 => '/2011/08/comment-dormiront-les-moines.html',
        23 => '/2011/08/lexcommunication-pour-les-fautes.html',
        24 => '/2011/08/quelle-doit-etre-la-mesure-de.html',
        25 => '/2011/08/les-fautes-graves.html',
        26 => '/2011/08/ceux-qui-sans-permission-se-joignent.html',
        27 => '/2011/08/quelle-sollicitude-labbe-doit-avoir.html',
        28 => '/2011/08/ceux-qui-souvent-repris-refusent-de-se.html',
        29 => '/2011/08/si-lon-doit-recevoir-de-nouveau-les.html',
        30 => '/2011/08/comment-corriger-les-jeunes-enfants.html',
        31 => '/2011/08/les-qualites-que-doit-avoir-le.html',
        32 => '/2011/08/les-outils-et-objets-du-monastere.html',
        33 => '/2011/08/si-les-moines-doivent-avoir-quelque.html',
        34 => '/2011/08/si-tous-doivent-recevoir-egalement-le.html',
        35 => '/2011/08/les-semainiers-de-la-cuisine.html',
        36 => '/2011/08/les-freres-malades.html',
        37 => '/2011/08/les-vieillards-et-les-enfants.html',
        38 => '/2011/08/le-lecteur-de-semaine.html',
        39 => '/2011/08/la-mesure-de-la-nourriture.html',
        40 => '/2011/08/la-mesure-de-la-boisson.html',
        41 => '/2011/08/quelle-heure-les-freres-doivent-prendre.html',
        42 => '/2011/08/que-personne-ne-parle-apres-complies.html',
        43 => '/2011/08/ceux-qui-arrivent-en-retard-loeuvre-de.html',
        44 => '/2011/08/comment-les-excommunies-font.html',
        45 => '/2011/08/ceux-qui-se-trompent-loratoire.html',
        46 => '/2011/08/ceux-qui-font-des-fautes-en-quelque.html',
        47 => '/2011/08/la-charge-dannoncer-loeuvre-de-dieu.html',
        48 => '/2011/08/le-travail-manuel-de-chaque-jour.html',
        49 => '/2011/08/lobservance-du-careme.html',
        50 => '/2011/08/les-freres-qui-travaillent-loin-de.html',
        51 => '/2011/08/les-freres-qui-ne-sen-vont-qua-faible.html',
        52 => '/2011/08/loratoire-du-monastere.html',
        53 => '/2011/08/la-reception-des-hotes.html',
        54 => '/2011/08/si-un-moine-peut-recevoir-des-lettres.html',
        55 => '/2011/08/les-vetements-et-les-chaussures-des_08.html',
        56 => '/2011/08/la-table-de-labbe.html',
        57 => '/2011/08/les-artisans-du-monastere.html',
        58 => '/2011/08/la-maniere-de-recevoir-les-freres.html',
        59 => '/2011/08/les-fils-de-notables-ou-de-pauvres-qui.html',
        60 => '/2011/08/les-pretres-qui-desireraient-se-fixer.html',
        61 => '/2011/08/comment-recevoir-les-moines-etrangers.html',
        62 => '/2011/08/les-pretres-du-monastere.html',
        63 => '/2011/08/le-rang-garder-dans-la-communaute.html',
        64 => '/2011/08/linstitution-de-labbe.html',
        65 => '/2011/08/le-prieur-du-monastere.html',
        66 => '/2011/08/les-portiers-du-monastere.html',
        67 => '/2011/08/des-freres-que-lon-envoie-en-voyage.html',
        68 => '/2011/08/si-lon-enjoint-un-frere-des-choses.html',
        69 => '/2011/08/que-nul-dans-le-monastere-ne-se.html',
        70 => '/2011/08/que-nul-ne-se-permette-de-frapper-tout.html',
        71 => '/2011/08/que-les-freres-sobeissent-mutuellement.html',
        72 => '/2011/08/le-bon-zele-que-doivent-avoir-les.html',
        73 => '/2011/08/toute-la-pratique-de-la-justice-nest.html',
    );

    public function __construct()
    {
        $this->images = array_flip($this->images);
        $this->bible = implode('|', $this->bible);
        $this->images = require __DIR__ . '/../data/images.php';
    }

    /**
     *
     * @param array $latinChapterLines
     * @param array $frenchChapterLines
     * @throws Exception
     */
    public function checkLineNumbers($latinChapterLines, $frenchChapterLines)
    {
        if (array_keys($latinChapterLines) != array_keys($frenchChapterLines)) {
            throw new Exception('first numbers do not match');
        }

        foreach(array_keys($latinChapterLines) as $paragraphNumber) {
            if (count($latinChapterLines[$paragraphNumber]) != count($frenchChapterLines[$paragraphNumber])) {
                throw new Exception("number count do not match in paragraph: $paragraphNumber");
            }

            foreach(array_keys($latinChapterLines[$paragraphNumber]) as $lineIndex) {
                if ($latinChapterLines[$paragraphNumber][$lineIndex]['number'] != $frenchChapterLines[$paragraphNumber][$lineIndex]['number']) {
                    throw new Exception("number do not match in line: $lineIndex");
                }
            }
        }
    }

    /**
     *
     * @param array $frenchChapter
     * @throws Exception
     */
    public function checkLinksToBible($frenchChapter)
    {
        if (isset($frenchChapter['notes'])) {
            $frenchChapter['lines'][] = $frenchChapter['notes'];
        }

        foreach($frenchChapter['lines'] as $lines) {
            foreach($lines as $line) {
                if (preg_match_all('~\(([^)]+)\)~', $line['text'], $matches)) {
                    foreach($matches[1] as $links) {
                        foreach(explode('; ', $links) as $link) {
                            if (preg_match('~^(cf. )?(' . $this->bible . ') \d+(?!,)$~', $link) or
                                preg_match('~^(cf. )?(' . $this->bible . ') \d+, \d+(?!-)$~', $link) or
                                preg_match('~^(cf. )?(' . $this->bible . ') \d+, \d+-\d+$~', $link)
                            ) {
                                continue;
                            }

                            throw new Exception('invalid link to bible: ' . $line['text']);
                        }
                    }
                }
            }
        }
    }

    /**
     *
     * @param array $latinChapterLines
     * @throws Exception
     */
    public function checkLinksToImages($latinChapterLines)
    {
        foreach($latinChapterLines as $lines) {
            foreach($lines as $line) {
                if (preg_match('~-f. [^\]\-]+-~', $line['text'], $match)) {
                    $text = $match[0];

                    if (! isset($this->images[$text])) {
                        throw new Exception('invalid image link: ' . $line['text']);
                    }                }
            }
        }
    }

    /**
     *
     * @param array $chapter
     * @return array
     * @throws Exception
     */
    public function checkNoteNumbers($chapter)
    {
        $noteNumbers = [];

        $chapter['lines'][][] = $chapter['title'];

        foreach($chapter['lines'] as $lines) {
            foreach($lines as $line) {
                if (preg_match_all('~\[([^\]]+)\]~', $line['text'], $matches)) {
                    foreach($matches[1] as $number) {
                        if (! isset($chapter['notes'][$number])) {
                            throw new Exception('missing text note for line: ' . $line['text']);
                        }

                        $noteNumbers[$number] = true;
                    }
                }
            }
        }

        return $noteNumbers;
    }

    /**
     *
     * @param array $chapterNotes
     * @param array $noteNumbers
     * @throws Exception
     */
    public function checkNoteTexts($chapterNotes, $noteNumbers)
    {
        foreach ($chapterNotes as $number => $note) {
            $number = $note['number'];
            $text = $note['text'];

            if (! isset($noteNumbers[$number])) {
                throw new Exception("unused note text: $number $text");
            }
        }
    }

    /**
     *
     * @param string $html
     * @return string
     */
    public function fixPunctuation($html) {
        $html = preg_replace('~« ~', '«&nbsp;', $html);
        $html = preg_replace('~ (»|\?|!|:)~', '&nbsp;$1', $html);

        return $html;
    }

    /**
     *
     * @param string $line
     * @return string
     */
    public function makeFrenchLine($line) {
        $line = array_map('trim', $line);
        $line = sprintf(
            '<span class="sb-line"><span class="sb-number">%s</span> <span class="sb-text">%s</span></span>',
            $line['number'],
            $line['text']);

        return $line;
    }

    /**
     *
     * @param string $latinTitle
     * @param string $frenchTitle
     * @param array $paragraphs
     * @param array $latinNotes
     * @param array $frenchNotes
     * @param int $number
     * @return string
     */
    public function makeHtml($latinTitle, $frenchTitle, $paragraphs, $latinNotes, $frenchNotes, $number)
    {
        static $pattern =
'
<!--
  Règle de saint Benoît
  %s

  Generated %s

  @copyright %d Michel Corne
  @license   http://www.opensource.org/licenses/gpl-3.0.html GNU GPL v3
-->

<table class="sb-content">
<tr class="sb-first">
<td class="sb-left"><div class="sb-chapter"><a href="%s">Chapitre précédent </a></div>
<div class="sb-title"><span class="sb-number">%s</span><span class="sb-text">%s</span></div>
</td>
<td class="sb-right"><a href="%s"><img class="sb-image" src="%s" /></a><div class="sb-chapter"><a href="%s">Chapitre suivant</a></div>
<div class="sb-title"><span class="sb-number">%s</span><span class="sb-text notranslate">%s</span></div>
</td>
</tr>
%s
<tr class="sb-notes"><td class="sb-left">%s</td><td class="sb-right">%s</td></tr>
<tr class="sb-last">
<td class="sb-left"><div class="sb-chapter"><a href="%s">Chapitre précédent </a></div></td>
<td class="sb-right"><div class="sb-chapter"><a href="%s">Chapitre suivant</a></div></td>
</tr>
</table>';

        $icon = isset($this->images[$number])? $this->images[$number] : $this->images['default'];

        if ($number = $frenchTitle['number']) {
            $number .= '.';
        }

        $nextChapter = ($number + 1) % 74;
        $previousChapter = ($number - 1 + 74) % 74;

        $html = sprintf($pattern,
            $frenchTitle['text'],
            date('c'), // generation date
            date('Y'), // copyright year
            $this->urls[$previousChapter], $number, $frenchTitle['text'],
            $icon[0], $icon[1], $this->urls[$nextChapter], $latinTitle['number'], $this->makeLatinCorrections($latinTitle['text']),
            $paragraphs, $frenchNotes, $latinNotes,
            $this->urls[$previousChapter], $this->urls[$nextChapter]);

        return $html;
    }

    /**
     *
     * @param string $line
     * @return string
     */
    public function makeLatinLine($line) {
        $line = array_map('trim', $line);
        $line = sprintf(
            '<span class="sb-line"><span class="sb-number">%s</span> <span class="sb-text notranslate">%s</span></span>',
            $line['number'],
            $this->makeLatinCorrections($line['text']));

        return $line;
    }

    /**
     *
     * @param string $html
     * @return string
     */
    public function makeLinksToBible($html)
    {
        $html = preg_replace_callback('~(' . $this->bible . ') \d+, \d+-\d+~', array($this, 'replaceLinkToBible'), $html);
        $html = preg_replace_callback('~(' . $this->bible . ') \d+, \d+~', array($this, 'replaceLinkToBible'), $html);
        $html = preg_replace_callback('~(' . $this->bible . ') \d+~', array($this, 'replaceLinkToBible'), $html);

        $html = str_replace(self::SPECIAL_CHAR, ' ', $html);

        $html = str_replace('(', '<span class="sb-bible-ref">(', $html);
        $html = str_replace(')', ')</span>', $html);

        $html = str_replace('cf. ', 'cf.&nbsp;', $html);

        return $html;
    }

    /**
     *
     * @param string $html
     * @return string
     */
    public function makeLinksToImages($html)
    {
        $html = preg_replace_callback('~(-f. )([^\-]+)(-)~i', array($this, 'replaceLinkToMontserrat'), $html);
        $html = preg_replace_callback('~-sg. ([^\-]+)-~i', array($this, 'replaceLinkToSaintGall'), $html);

        return $html;
    }

    /**
     *
     * @param string $line
     * @return string
     */
    public function makeLatinCorrections($line)
    {
        // two words or more in saint-gall, none in montserrat, replaces for ex (*~hæc omnia)
        $line = preg_replace('/\(\*~((?:[a-zA-Z., ]|æ|œ|Æ|Œ|«|»|:)+)\)/',
            '<span class="sb-montserrat" title="[Saint-Gall] $1"><span class="sb-no-difference">[...]</span></span>' .
            '<span class="sb-saint-gall" title="[Montserrat] aucun mot correspondant"><span class="sb-difference">$1</span></span>',
            $line);
        // two words or more in montserrat, none in saint-gall, replaces for ex (hæc omnia~*)
        $line = preg_replace('/\(((?:[a-zA-Z., ]|æ|œ|Æ|Œ|«|»|:)+)~\*\)/',
            '<span class="sb-montserrat" title="[Saint-Gall] aucun mot correspondant"><span class="sb-difference">$1</span></span>' .
            '<span class="sb-saint-gall" title="[Montserrat] $1"><span class="sb-no-difference">[...]</span></span>',
            $line);
        // two words or more in one manuscript, one or more in the other, replaces for ex "(nos~suos non)"
        $line = preg_replace('/\(((?:[a-zA-Z., ]|æ|œ|Æ|Œ|«|»|:)+)~((?:[a-zA-Z., ]|æ|œ|Æ|Œ|«|»|:)+)\)/',
            '<span class="sb-montserrat" title="[Saint-Gall] $2"><span class="sb-difference">$1</span></span>' .
            '<span class="sb-saint-gall" title="[Montserrat] $1"><span class="sb-difference">$2</span></span>',
            $line);

        // correction of two words or more in montserrat, replaces for ex "(inquieto#in quieto)"
        $line = preg_replace('/\(((?:[a-zA-Z ]|æ|œ|Æ|Œ)+)#((?:[a-zA-Z ]|æ|œ|Æ|Œ)+)\)/',
            '<span class="sb-montserra" title="[Montserrat] $2"><span class="sb-correction">$1</span></span>', $line);

        // one word in saint-gall, none in montserrat, replaces for ex "*~ab"
        $line = preg_replace('/\*~((?:[a-zA-Z]|æ|œ|Æ|Œ)+)/',
            '<span class="sb-montserrat" title="[Saint-Gall] $1"><span class="sb-no-difference">[...]</span></span>' .
            '<span class="sb-saint-gall" title="[Montserrat] aucun mot correspondant"><span class="sb-difference">$1</span></span>',
            $line);
        // one word in montserrat, none in saint-gall, replaces for ex "ut~*"
        $line = preg_replace('/((?:[a-zA-Z]|æ|œ|Æ|Œ)+)~\*/',
            '<span class="sb-montserrat" title="[Saint-Gall] aucun mot correspondant"><span class="sb-difference">$1</span></span>' .
            '<span class="sb-saint-gall" title="[Montserrat] $1"><span class="sb-no-difference">[...]</span></span>',
            $line);
        // one word in each manuscript, replaces for ex "imple~comple"
        $line = preg_replace('/((?:[a-zA-Z]|æ|œ|Æ|Œ)+)~((?:[a-zA-Z]|æ|œ|Æ|Œ)+)/',
            '<span class="sb-montserrat" title="[Saint-Gall] $2"><span class="sb-difference">$1</span></span>' .
            '<span class="sb-saint-gall" title="[Montserrat] $1"><span class="sb-difference">$2</span></span>',
            $line);

        // correction of one word in montserrat, replaces for ex "dissimulet#dissimilet"
        $line = preg_replace('/((?:[a-zA-Z]|æ|œ|Æ|Œ)+)#((?:[a-zA-Z]|æ|œ|Æ|Œ)+)/',
            '<span class="sb-montserra" title="[Montserrat] $2"><span class="sb-correction">$1</span></span>', $line);

        // replaces punctuation
        // $line = preg_replace('/\*~([,.;])/', '<span class="sb-saint-gall">$1</span>', $line);
        // $line = preg_replace('/([|,.;])~\*/', '<span class="sb-montserrat">$1</span>', $line);
        // $line = preg_replace('/([|,.;])~([,.;])/', '<span class="sb-montserrat">$1</span><span class="sb-saint-gall">$2</span>', $line);

        return $line;
    }

    /**
     *
     * @param array $frenchChapter
     * @param array $latinChapter
     * @param int $number
     * @return string
     */
    public function makeMessage($frenchChapter, $latinChapter, $number)
    {
        $this->checkLineNumbers($latinChapter['lines'], $frenchChapter['lines']);

        $noteNumbers = $this->checkNoteNumbers($latinChapter);

        if (isset($latinChapter['notes'])) {
            $this->checkNoteTexts($latinChapter['notes'], $noteNumbers);
        }

        $noteNumbers = $this->checkNoteNumbers($frenchChapter);

        if (isset($frenchChapter['notes'])) {
            $this->checkNoteTexts($frenchChapter['notes'], $noteNumbers);
        }

        $this->checkLinksToBible($frenchChapter);

        $this->checkLinksToImages($latinChapter['lines']);

        $paragraphs = $this->makeParagraphs($latinChapter['lines'], $frenchChapter['lines']);
        $latinNotes = isset($latinChapter['notes'])? $this->makeNotes($latinChapter['notes']) : null;
        $frenchNotes = isset($frenchChapter['notes'])? $this->makeNotes($frenchChapter['notes']) : null;
        $html = $this->makeHtml($latinChapter['title'], $frenchChapter['title'], $paragraphs, $latinNotes, $frenchNotes, $number);

        $html = $this->makeLinksToImages($html);
        $html = $this->makeLinksToBible($html);
        $html = $this->makeNoteRefNumbers($html);

        $html = str_replace('|', ',', $html);

        // removes leftover questions on translation -- Obsolete ?
        $html = preg_replace('~\([^?)]*\?\)~', '', $html);

        $html = str_replace('{', '(', $html);
        $html = str_replace('}', ')', $html);

        $html = $this->fixPunctuation($html);

        return $html;
    }

    /**
     *
     * @param string $html
     * @return string
     */
    public function makeNoteRefNumbers($html)
    {
        $html = preg_replace('~\[(\d+|[a-z])\]~',
            '<span class="sb-note-ref">&nbsp;<a name="note-ref-$1" href="#note-text-$1">$1</a></span>',
            $html);

        return $html;
    }

    /**
     *
     * @param string $note
     * @return string
     */
    public function makeNote($note)
    {
        $format = '<div><a class="sb-note-number" name="note-text-%1$s" href="#note-ref-%1$s">%1$s</a>. <span class="sb-note-text">%2$s</span></div>';

        $note = sprintf($format, $note['number'], $note['text']);

        return $note;
    }

    /**
     *
     * @param array $notes
     * @return array
     */
    public function makeNotes($notes)
    {
        $notes = array_map(array($this, 'makeNote'), $notes);
        $notes = implode('', $notes);

        return $notes;
    }

    /**
     *
     * @param array $paragraph
     * @param string $callback
     * @param string $class
     * @return string
     */
    public function makeParagraph($paragraph, $callback, $class)
    {
        $lines = array_map(array($this, $callback), $paragraph);
        $html = sprintf("<td class=\"%s\"><span class=\"sb-paragraph\">%s</span></td>", $class, implode(' ', $lines));

        return $html;
    }

    /**
     *
     * @param array $latinChapterLines
     * @param array $frenchChapterLines
     * @return string
     */
    public function makeParagraphs($latinChapterLines, $frenchChapterLines)
    {
        foreach(array_keys($latinChapterLines) as $number) {
            $paragraphs[] = sprintf(
                "<tr class=\"sb-middle\">\n%s\n%s\n</tr>",
                $this->makeParagraph($frenchChapterLines[$number], 'makeFrenchLine', 'sb-left'),
                $this->makeParagraph($latinChapterLines[$number], 'makeLatinLine', 'sb-right'));
        }

        $html = implode("\n", $paragraphs);

        return $html;
    }

    /**
     *
     * @param string $line
     * @return array
     * @throws Exception
     */
    public function parseLine($line)
    {
        if (! preg_match('~(\d+) (.+)~', $line, $match)) {
            throw new Exception('cannot parse line: ' . $line);
        }

        // this is a french chapter
        list(, $number, $text) = $match;

        if ($number < 1) {
            throw new Exception('line number lower than 1: ' . $line);
        }

        if ($number != ++$this->prevLine) {
            throw new Exception('not expecting line: ' . $line);
        }

        return array($number, $text);
    }

    /**
     *
     * @param string $file
     * @return array
     * @throws Exception
     */
    public function parseFile($file)
    {
        if (! $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)) {
            throw new Exception("cannot read file: $file");
        }

        $this->prevChapter = -1;
        $this->prevLine = 0;
        $this->prevNote = 0;
        $isFirstLine = false;
        $firstLineNb = 0;

        foreach($lines as $line) {
            $type = $line[0];
            $line = substr($line, 1);

            switch($type) {
                case '+': // this is a chapter number and title
                    list($index, $number, $text) = $this->parseTitle($line);
                    $chapters[$index]['title'] = array('number' => $number, 'text' => $text);
                    break;

                case '*': // this is the first line of a paragraph
                    $isFirstLine = true;
                    // break;

                case '-': // this is a line within a paragraph
                    if (! isset($index)) {
                        throw new Exception('expecting chapter instead of: ' . $line);
                    }

                    list($number, $text) = $this->parseLine($line);

                    if ($isFirstLine) {
                        $isFirstLine = false;
                        $firstLineNb = $number;
                    }

                    if (! $firstLineNb) {
                        throw new Exception('expecting paragraph first line instead of: ' . $line);
                    }

                    $chapters[$index]['lines'][$firstLineNb][$number] = array('number' => $number, 'text' => $text);
                    break;

                case '=': // this is a note
                    if (! isset($index)) {
                        throw new Exception('expecting chapter instead of: ' . $line);
                    }

                    list($number, $text) = $this->parseNote($line);
                    $chapters[$index]['notes'][$number] = array('number' => $number, 'text' => $text);
                    break;

            }
        }

        return $chapters;
    }

    /**
     *
     * @return array
     * @throws Exception
     */
    public function parseFiles()
    {
        $frenchChapters = $this->parseFile(__DIR__ . '/../data/schmitz.txt');
        $latinChapters = $this->parseFile(__DIR__ . '/../data/montserrat.txt');

        if (array_keys($frenchChapters) != array_keys($latinChapters)) {
            throw new Exception('chapters indexes do not match');
        }

        return array($frenchChapters, $latinChapters);
    }

    /**
     *
     * @param string $line
     * @return array
     * @throws Exception
     */
    public function parseNote($line)
    {
        if (preg_match('~(\d+) (.+)~', $line, $match)) {
            // this is a note number
            // todo: should check this is in french text
            list(, $number, $text) = $match;

            if ($number < 1) {
                throw new Exception('note number lower than 1: ' . $line);
            }

            if ($number != ++$this->prevNote) {
                throw new Exception('not expecting note: ' . $line);
            }

        } else if (preg_match('~([a-z]+) (.+)~', $line, $match)) {
            // this is a note letter
            // todo: should check this is in latin text, and in alphabetical order
            list(, $number, $text) = $match;

        } else {
            throw new Exception('cannot parse note: ' . $line);
        }

        return array($number, $text);
    }

    /**
     *
     * @param string $line
     * @return array
     * @throws Exception
     */
    public function parseTitle($line)
    {
        if ($line == 'Prologus' or
            strpos($line, 'Incipit prologus regulae sancti Benedicti abbatis') or
            $line == 'PROLOGUE')
        {
            if ($this->prevChapter != -1) {
                throw new Exception('not expecting prologue: ' . $line);
            }

            $number = '';
            $this->prevChapter = 0;
            $text = $line;

        } else if (preg_match('~Chapitre (\d+) (.+)~', $line, $match)) {
            // this is a french chapter
            if ($this->prevChapter == -1) {
                throw new Exception('expecting prologue instead of: ' . $line);
            }

            list(, $number, $text) = $match;

            if ($number < 1) {
                throw new Exception('chapter number lower than 1: ' . $line);
            }

            if ($number > 73) {
                throw new Exception('chapter number higher that 73: ' . $line);
            }

            if ($number != ++$this->prevChapter) {
                throw new Exception('not expecting chapter: ' . $line);
            }

        } else if (preg_match('~([IVXL]+)\. (.+)~', $line, $match)) {
            // this is a latin chapter
            if ($this->prevChapter == -1) {
                throw new Exception('expecting prologus instead of: ' . $line);
            }

            list(, $number, $text) = $match;

            if (! in_array($number, $this->romanNumbers)) {
                throw new Exception('chapter number out of range: ' . $line);
            }

            if ($number != $this->romanNumbers[++$this->prevChapter]) {
                throw new Exception('not expecting chapter: ' . $line);
            }

        } else {
            throw new Exception('cannot parse chapter: ' . $line);
        }

        // resets line number
        $this->prevLine = 0;
        $this->prevNote = 0;

        $text = mb_strtoupper($text, 'utf-8');

        return array($this->prevChapter, $number, $text);
    }

    /**
     * Reads a file.
     *
     * @param string $file The file name
     *
     * @throws Exception
     *
     * @return string The file content
     */
    public function readFile($file)
    {
        if (! $content = @file_get_contents($file)) {
            throw new Exception("cannot read file: $file");
        }

        return $content;
    }

    /**
     * Removes the generated date from a docblock for comparison purposes.
     *
     * @param string $html The HTML content of a chapter
     *
     * @return string The HTML content without the generated date
     */
    public function removeGeneratedDate($html)
    {
        // removes the date in the chapter being translated
        $html = preg_replace('~^\s*Generated.+?$~m', '', $html);
        $html = preg_replace('~^\s*@copyright.+?$~m', '', $html);

        return $html;
    }

    /**
     *
     * @param array $text
     * @return string
     */
    public function replaceLinkToBible($text)
    {
        $format =
'<a target="sbbible" href="http://lire.la-bible.net/index.php?reference=%s&versions[]=BFC"
 title="Afficher le texte de la Bible dans un nouvel onglet">%s</a>';

        $text = str_replace(', ', ':', $text[0]);
        $text = str_replace('-', '&#8209;', $text);
        $text = str_replace(' ', '&nbsp;', $text);

        $reference = str_replace(' ', '+', $text);

        $link = sprintf($format, $reference, $text);
        $link = str_replace(' ', self::SPECIAL_CHAR, $link);

        return $link;
    }

    /**
     *
     * @param array $text
     * @return string
     */
    public function replaceLinkToMontserrat($text)
    {
        $format =
'<span class="sb-manuscript" title="Afficher la page du manuscrit de Monserrat dans un nouvel onglet"
>[<a target="sbmontserrat" href="http://www.lluisvives.com//servlet/SirveObras/50179280531265707460891/ima%s.htm">f.%s</a>]</span>';

        $link = sprintf($format, $this->images[strtolower($text[0])], strtolower($text[2]));

        return $link;
    }

    /**
     *
     * @param array $text
     * @return string
     */
    public function replaceLinkToSaintGall($text)
    {
        $format =
'<span class="sb-manuscript" title="Afficher la page du manuscrit de Saint-Gall dans un nouvel onglet"
>[<a target="sbsaintgall" href="http://www.e-codices.unifr.ch/fr/csg/0914/%1$s/medium">sg.%1$s</a>]</span>';

        $link = sprintf($format, $text[1]);

        return $link;
    }

    public function saveMessage($html, $frenchChapter, $blog, $number)
    {
        $url = $this->urls[$number];
        $file = __DIR__ . "/../messages/$number-" . basename($url);
        $prevHtml = file_exists($file)? $this->readFile($file) : null;

        if ($this->removeGeneratedDate($html) == $this->removeGeneratedDate($prevHtml)) {
            // the chapter is the same as the currently saved version, no change
            return false;
        }

        echo "$number ";

        if (! $blog) {
            // this is the verification mode, no publishing
            return true;
        }

        // removes line breaks because Blogger replaces them with <br> for some reason which screws up the display
        // although messages are set to use HTML as it is and to use <br> for line feeds
        $content = str_replace("\n", ' ', $html);
        $blog->patchPost($url, $frenchChapter['title'], $content);
        $this->writeFile($file, $html);

        return true;
    }

    /**
     *
     * @param array $htmls
     * @param array $frenchChapters
     * @param Blog|null $blog
     * @return string
     */
    public function saveMessages($htmls, $frenchChapters, $blog = null)
    {
        $publishedCount = 0;

        foreach ($htmls as $number => $html) {
            $publishedCount += $this->saveMessage($html, $frenchChapters[$number], $blog, $number);
        }

        if ($blog) {
            if ($publishedCount == 0) {
                $result = 'No chapter has changed, no chapter was published.';
            } elseif ($publishedCount == 1) {
                $result = "\n" . 'The chapter has changed and was published successfully.';
            } else {
                $result = "\n" . "The $publishedCount chapters have changed and were published successfully.";
            }
        } else {
            if ($publishedCount == 0) {
                $result = 'No chapter has changed, no chapter needs to be published.';
            } elseif ($publishedCount == 1) {
                $result = "\n" . 'The chapter has changed and need to be published.';
            } else {
                $result = "\n" . "The $publishedCount chapters have changed and will need to be published.";
            }
        }

        return $result;
    }

    /**
     * Saves the HTML content of an chapter into a temporary file.
     *
     * The chapter is saved in messages/temp.html that is used for checking changes before commiting them to the blog.
     *
     * @param string $html   The HTML content of the chapter
     * @param int    $number The chapter number
     *
     * @return string The result of the action to be displayed to the output
     */
    public function saveTempMessage($html, $number)
    {
        $temp     = 'messages/temp.html';
        $file     = __DIR__ . "/../$temp";
        $prevHtml = file_exists($file) ? $this->readFile($file) : null;

        if ($this->removeGeneratedDate($html) == $this->removeGeneratedDate($prevHtml)) {
            $result = "The chapter is already up to date in $temp.";
        } else {
            $this->writeFile(__DIR__ . "/../$temp", $html);
            $result = "The chapter was saved successfully in $temp.";
        }

        return $result;
    }

    /**
     * Writes into a file.
     *
     * @param string $file    The file name
     * @param string $content The file content
     *
     * @throws Exception
     */
    public function writeFile($file, $content)
    {
        if (! @file_put_contents($file, $content)) {
            throw new Exception("cannot write file: $file");
        }
    }
}
