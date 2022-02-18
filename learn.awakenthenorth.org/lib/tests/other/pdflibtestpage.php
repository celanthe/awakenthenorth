<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Produces a sample PDF using lib/pdflib.php
 *
 * @package    core
 * @copyright  2009 David Mudrak <david.mudrak@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/pdflib.php');

require_login();
$context = context_system::instance();
require_capability('moodle/site:config', $context);

$getpdf     = optional_param('getpdf', 0, PARAM_INT);
$fontfamily = optional_param('fontfamily', PDF_FONT_NAME_MAIN, PARAM_ALPHA);  // to be configurable

if (!$fontfamily) {
    $fontfamily = PDF_FONT_NAME_MAIN;
}

/**
 * Extend the standard PDF class to get access to some protected values we want to display
 * at the test page.
 *
 * @copyright 2009 David Mudrak <david.mudrak@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
if ($getpdf) {
    $doc = new pdf();

    $doc->SetTitle('Moodle PDF library test');
    $doc->SetAuthor('Moodle ' . $CFG->release);
    $doc->SetCreator('lib/tests/other/pdflibtestpage.php');
    $doc->SetKeywords('Moodle, PDF');
    $doc->SetSubject('This has been generated by Moodle as its PDF library test page');
    $doc->SetMargins(15, 30);

    $doc->setPrintHeader(true);
    $doc->setHeaderMargin(10);
    $doc->setHeaderFont(array($fontfamily, 'b', 10));
    $doc->setHeaderData('pix/moodlelogo.png', 40, $SITE->fullname, $CFG->wwwroot);

    $doc->setPrintFooter(true);
    $doc->setFooterMargin(10);
    $doc->setFooterFont(array($fontfamily, '', 8));

    $doc->AddPage();

    $doc->SetTextColor(255,255,255);
    $doc->SetFillColor(255,203,68);
    $doc->SetFont($fontfamily, 'B', 24);
    $doc->Cell(0, 0, 'Moodle PDF library test', 0, 1, 'C', 1);

    $doc->SetFont($fontfamily, '', 12);
    $doc->Ln(6);
    $doc->SetTextColor(0,0,0);

    $c  = '<h3>General information</h3>';
    $c .= 'Moodle release: '            . $CFG->release . '<br />';
    $c .= 'PDF producer: TCPDF '        . TCPDF_STATIC::getTCPDFVersion() . ' (http://www.tcpdf.org) <br />';
    $c .= 'Font family used: '          . $fontfamily   . '<br />';

    $c .= '<h3>Current settings</h3>';
    $c .= '<table border="1"  cellspacing="0" cellpadding="1">';
    foreach (array('K_PATH_MAIN', 'K_PATH_URL', 'K_PATH_FONTS', 'PDF_FONT_NAME_MAIN', 'K_PATH_CACHE', 'K_PATH_IMAGES', 'K_BLANK_IMAGE',
                        'K_CELL_HEIGHT_RATIO', 'K_SMALL_RATIO', 'PDF_CUSTOM_FONT_PATH', 'PDF_DEFAULT_FONT') as $setting) {
        if (defined($setting)) {
            $c .= '<tr style="font-size: x-small;"><td>' . $setting . '</td><td>' . constant($setting) . '</td></tr>';
        }
    }
    $c .= '</table><br />';

    $c .= '<h3>Available font families</h3>';
    $fontfamilies = $doc->get_font_families();
    $list = array();
    foreach ($fontfamilies as $family => $fonts) {
        $f = $family;
        $spacer = '';
        if ($doc->is_core_font_family($family)) {
            $f .= '<sup>*</sup>';
        } else {
            $spacer = ' ';
        }
        if (count($fonts) > 1) {
            $f .= $spacer . '<i>(' . implode(', ', $fonts) . ')</i>';
        }
        $list[] = $f;
    }
    $c .= implode(', ', $list);
    $c .= '<p><i><small>Note: * Standard core fonts are not embedded in PDF files, PDF viewers are using local fonts.</small></i></p>';

    $c .= '<h3>Installed languages and their alphabets</h3>';
    $languages = array();
    $langdirs = get_list_of_plugins('lang', '', $CFG->dataroot);
    array_unshift($langdirs, 'en');
    foreach ($langdirs as $langdir) {
        $enlangconfig = $CFG->dirroot . '/lang/en/langconfig.php';
        if ('en' == $langdir) {
            $langconfig = $enlangconfig;
        } else {
            $langconfig = $CFG->dataroot . '/lang/' . $langdir . '/langconfig.php';
        }
        // Ignore parents here for now.
        $string = array();
        if (is_readable($langconfig)) {
            include($langconfig);
            if (is_array($string)) {
                $languages[$langdir] = new stdClass();
                $languages[$langdir]->langname = isset($string['thislanguage']) ? $string['thislanguage'] : '(unknown)';
                $languages[$langdir]->alphabet = isset($string['alphabet']) ? '"' . $string['alphabet'] . '"': '(no alphabet defined)';
            }
        }
    }
    $c .= '<dl>';
    foreach ($languages as $langcode => $language) {
        $c .= '<dt>' . $language->langname . ' (' . $langcode . ')</dt>';
        $c .= '<dd>' . $language->alphabet . '</dd>';
    }
    $c .= '</dl>';

    $doc->writeHTML($c);

    $doc->Output('pdflibtestpage.pdf');
    exit();
}

$PAGE->set_url('/lib/tests/other/pdflibtestpage.php');
$PAGE->set_context($context);
$PAGE->set_title('PDF library test');
$PAGE->set_heading('PDF library test');

echo $OUTPUT->header();
echo $OUTPUT->heading('Press the button to generate test PDF', 2);
echo $OUTPUT->continue_button(new moodle_url($PAGE->url, array('getpdf' => 1, 'fontfamily' => PDF_FONT_NAME_MAIN)));
echo $OUTPUT->footer();
