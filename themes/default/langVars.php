<?php

$known_langs = array('fr', 'en');
$user_pref_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

foreach ($user_pref_langs as $idx => $lang) {
    $lang = substr($lang, 0, 2);
    if (in_array($lang, $known_langs)) {
        break;
    }
}
switch ($lang) {
    case 'en':
        setlocale(LC_ALL, 'en_UK');
        break;
    case 'fr':
    default:
        $lang = 'fr';
        setlocale(LC_ALL, 'fr_FR');
        break;
}
$GLOBALS['lang'] = $lang;

$headline = [];
$bioimage = Registry::get('bioimage');
$team = Registry::get('team');
$catch = Registry::get('catch');
$catchImage = $catch['catchimage'];

switch ($lang) {
    case 'fr':
        $headline[] = "Sous la direction du Docteur Ronald Virag";
        $headline[] = "Membre de l’Académie Nationale de Chirurgie";
        $introfirstpart = site_meta('introfirstpart');
        $introsecondpart = site_meta('introsecondpart');
        $introthirdpart = site_meta('introthirdpart');
        $biofirstpart = Registry::get('biofirstpart');
        $biosecondpart = Registry::get('biosecondpart');
        $biothirdpart = Registry::get('biothirdpart');
        $knowmore = "En savoir plus";
        $ourteam = "Notre équipe";
        $accessbooks = "Accéder aux livres";
        $catchPhrase = $catch['catchphrase'];
        $contactus = "Nous contacter";
        $testyourself = "Testez-vous";
        $bookappointment = "Prendre rendez-vous";
        $publisherinfo = "Info éditeur";
        $legalnotices = "Mentions legales";
        $credits = "Credits";
        $siteplan = "Plan du site";
        $socialnetworks = "Reseaux sociaux";
        $address1 = site_meta('address1');
        $address2 = site_meta('address2');
        $mail = site_meta('mail');
        $telNumber = site_meta('telnumber');
        $dossierbigtitle = "Étude et information <br>en andrologie & sexologie.";
        $masculintitle = "Problème masculin";
        $feminintitle = "Problème féminin";
        break;
    case 'en':
        $headline[] = "Under the direction of Doctor Ronald Virag";
        $headline[] = "Member of the National Academy of Surgery";
        $introfirstpart = site_meta('introfirstpart_en');
        $introsecondpart = site_meta('introsecondpart_en');
        $introthirdpart = site_meta('introthirdpart_en');
        $biofirstpart = Registry::get('biofirstpart_en');
        $biosecondpart = Registry::get('biosecondpart_en');
        $biothirdpart = Registry::get('biothirdpart_en');
        for ($i = 0; $i < count($team); $i++) {
            $team[$i]->data['teammemberjob'] = $team[$i]->data['teammemberjob_en'];
        }
        $knowmore = "Learn more";
        $ourteam = "Our Team";
        $accessbooks = "Access to books";
        $catchPhrase = $catch['catchphrase_en'];
        $contactus = "Contact us";
        $testyourself = "Test yourself";
        $bookappointment = "Book an appointment";
        $publisherinfo = "Publisher informations";
        $legalnotices = "Terms and conditions";
        $credits = "Credits";
        $siteplan = "Site map";
        $socialnetworks = "Social networks";
        $address1 = site_meta('address1_en');
        $address2 = site_meta('address2_en');
        $mail = site_meta('mail_en');
        $telNumber = site_meta('telnumber_en');
        $dossierbigtitle = "Study and information <br>in andrology.";
        $masculintitle = "Male problem";
        $feminintitle = "Female problem";
        break;
    default:
        break;
}
?>