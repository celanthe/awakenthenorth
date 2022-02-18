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
 * Automatically generated strings for Moodle installer
 *
 * Do not edit this file manually! It contains just a subset of strings
 * needed during the very first steps of installation. This file was
 * generated automatically by export-installer.php (which is part of AMOS
 * {@link http://docs.moodle.org/dev/Languages/AMOS}) using the
 * list of strings defined in /install/stringnames.txt.
 *
 * @package   installer
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['admindirname'] = 'Halduskataloog';
$string['availablelangs'] = 'Saadaolevad keelepaketid';
$string['chooselanguagehead'] = 'Valige keel';
$string['chooselanguagesub'] = 'Valige Moodle’i keel. Valitud keelt kasutatakse õpikeskkonna vaikekeelena ja seda saab hiljem muuta.';
$string['clialreadyconfigured'] = 'Fail „config.php“ on juba olemas. Kasutage sellele saidile Moodle’i installimiseks faili „admin/cli/install_database.php“.';
$string['clialreadyinstalled'] = 'Konfiguratsioonifail config.php on juba olemas. Palun kasutage Moodle’i selles õpikeskkonnas uuendamiseks faili admin/cli/install_database.php.';
$string['cliinstallheader'] = 'Moodle’i {$a} käsureapõhine installiprogramm';
$string['databasehost'] = 'Andmebaasi host';
$string['databasename'] = 'Andmebaasi nimi';
$string['databasetypehead'] = 'Valige andmebaasi draiver';
$string['dataroot'] = 'Andmekataloog';
$string['datarootpermission'] = 'Andmekataloogide õigus';
$string['dbprefix'] = 'Tabeli eesliide';
$string['dirroot'] = 'Moodle’i kataloog';
$string['environmenthead'] = 'Keskkonna kontrollimine...';
$string['environmentsub2'] = 'Igal Moodle’i väljaandel on oma minimaalne PHP versiooni nõue ja kohustuslikud PHP- laiendused.
Täielik keskkonnakontroll tehakse enne iga installi ja versiooniuuendust. Kui te ei tea, kuidas installida uus versioon või lubada PHP-laiendused, pöörduge administraatori poole.';
$string['errorsinenvironment'] = 'Keskkonna sobivuse kontroll nurjus.';
$string['installation'] = 'Installimine';
$string['langdownloaderror'] = 'Keelt "{$a}" ei saanud alla laadida. Installimine jätkub inglise keeles.';
$string['memorylimithelp'] = '<p>Teie serveri PHP mälulimiit on praegu {$a}.</p>

<p>See võib hiljem tekitada Moodle’il mäluprobleeme,
   eriti kui teil on palju kasutajaid ja/või lubatud palju mooduleid.</p>

<p>Soovitatav on võimaluse korral konfigureerida suurem PHP limiit, näiteks 16M.
   Selle tegemiseks on mitu viisi.</p>
<ol>
<li>Kui võimalik, siis kompileerige PHP uuesti parameetriga <i>--enable-memory-limit</i>.
    See lubab Moodle’il ise mälulimiidi määrata.</li>
<li>Kui teil on juurdepääs teie php.ini failile, saate seal muuta sätte <b>memory_limit</b>
     väärtuse näiteks väärtuseks 40M.  Kui teil pole juurdepääsu,
    saate paluda administraatoril seda teha.</li>
<li>Mõnes PHP-serveris saab luua Moodle’i kataloogi faili .htaccess,
    mis sisaldab seda rida:
    <blockquote><div>php_value memory_limit 40M</div></blockquote>
    <p>Kuigi mõnes serveris tõkestab see <b>kõigi</b> PHP-lehtede tööd
    (kui vaatate lehti, näete tõrketeateid), nii et peate faili .htaccess eemaldama.</p></li>
</ol>';
$string['paths'] = 'Teed';
$string['pathserrcreatedataroot'] = 'Installiprogramm ei saanud andmete kataloogi ({$a->dataroot}) luua.';
$string['pathshead'] = 'Kinnita teed';
$string['pathsrodataroot'] = 'Andmete juurkataloog ei võimalda kirjutust.';
$string['pathsroparentdataroot'] = 'Ülemkataloog ({$a->parent}) ei võimalda kirjutust. Installiprogramm ei saanud andmete kataloogi ({$a->dataroot}) luua.';
$string['pathssubadmindir'] = 'Väga vähestes veebihostides on juhtpaneelile vm juurdepääsuks spetsiaalse URL-ina kasutusel „/admin“. Kahjuks ei vasta see Moodle’i administreerimislehtede tavaasukohale. Saate olukorda parandada, kui nimetate kataloogi admin oma installis ümber ja sisestate uue nime siin. Näiteks: <em>moodleadmin</em>. See parandab Moodle’is olevad administreerimisliidese lingid.';
$string['pathssubdataroot'] = '<p>Kataloog, kuhu Moodle salvestab kõigi kasutajate üleslaaditud failide sisu.</p>
<p>See kataloog peab olema veebiserveri kasutaja poolt (tavaliselt \'www-data\', \'nobody\' või \'apache\') nii loetav kui ka kirjutatav.</p>
<p>See ei tohi olla otse veebist juurdepääsetav.</p>
<p>Kui kataloogi pole praegu olemas, püüab installimisprotsess selle ise luua.</p>';
$string['pathssubdirroot'] = '<p>Moodle’i koodi sisaldava kataloogi täielik tee.</p>';
$string['pathssubwwwroot'] = '<p>Täielik veebiaadress, kustkaudu Moodle’ile juurde pääsetakse, s.t see aadress, mille kasutajad Moodle’ile juurdepääsemiseks oma brauseri aadressiribale sisestavad.</p>
<p>Moodle’ile poole võimalik juurde pääseda mitme aadressi kaudu. Kui teie õpikeskkond on juurdepääsetav mitme aadressi kaudu, valige neist lihtsaim ja määrake kõigilt teistelt aadressidelt püsiv ümbersuunamine.</p>
<p>Kui teie õpikeskkond on juurdepääsetav nii Internetist kui ka sisevõrgust, kasutage siin avalikku aadressi.</p>
<p>Kui praegune aadress pole õige, siis muutke oma brauseri aadressiribal URL ja alustage installi uuesti.</p>';
$string['pathsunsecuredataroot'] = 'Andmete juurkataloogi asukoht pole turvaline';
$string['pathswrongadmindir'] = 'Halduskataloogi pole olemas';
$string['phpextension'] = '{$a} PHP-laiendus';
$string['phpversion'] = 'PHP versioon';
$string['phpversionhelp'] = '<p>Moodle vajab vähemalt PHP versiooni 5.6.5 või 7.1 (versioonil 7.0.x on mõned mootoripiirangud).</p>
<p>Teie praegune versioon on {$a}.</p>
<p>Peate uuendama oma PHP või kolima hosti, kus on uuem PHP versioon.</p>';
$string['welcomep10'] = '{$a->installername} ({$a->installerversion})';
$string['welcomep20'] = 'Teile kuvatakse see leht, kuna olete edukalt oma arvutisse installinud ja
     käivitanud paketi <strong>{$a->packname} {$a->packversion}</strong>. Õnnitleme!';
$string['welcomep30'] = 'See <strong>{$a->installername}</strong> väljaanne hõlmab rakendusi, mille abil
    saab luua <strong>Moodle’i</strong> toimimiseks vajaliku keskkonna, nt:';
$string['welcomep40'] = 'Pakett sisaldab ka järgmist: <strong>Moodle {$a->moodlerelease} ({$a->moodleversion})</strong>.';
$string['welcomep50'] = 'Kõigi selle paketi rakenduste kasutamise kohta kehtivad nende vastavad
    litsentsid. Täielik <strong>{$a->installername}</strong> pakett on
    <a href="http://www.opensource.org/docs/definition_plain.html">avatud lähtekoodiga</a> ja seda levitatakse
    <a href="http://www.gnu.org/copyleft/gpl.html">GPL</a> litsentsi alusel.';
$string['welcomep60'] = 'Järgmistel lehtedel toodud lihtsate juhiste abil saate konfigureerida ja
    häälestada <strong>Moodle</strong>’i oma arvutis. Võite nõustuda
    vaikesätetega või muuta sätteid oma vajaduste järgi.';
$string['welcomep70'] = '<strong>Moodle’i</strong> installi jätkamiseks klõpsake nuppu Edasi.';
$string['wwwroot'] = 'Veebiaadress';
