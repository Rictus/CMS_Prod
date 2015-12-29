<?php
$address1 = site_meta('address1');
$address2 = site_meta('address2');
$mail = site_meta('mail');
$telNumber = site_meta('telnumber');
$telNumberNoWhiteSpace = str_replace(' ', '', $telNumber);

?>

<div class="mapContact">
    <div class="inner row">
        <div class="mapPicture col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <img src="<?php echo theme_url("./img/map.png"); ?>"
                 alt="Position géographique du bureau de Ronald Virag">
        </div>
        <div class="contactInformations col-lg-5 col-md-5 col-sm-6 col-xs-12">
            <div class="address"><?php echo site_meta('address1'); ?></div>
            <div class="town"><?php echo site_meta('address2'); ?></div>
            <br>

            <div class="tel">TÉL. <a class="inline-link hidden-link"
                                     href=<?php echo "'tel :" . $telNumberNoWhiteSpace."'>".$telNumber."</a>";?>
            </div>
            <div class="mail">MAIL <a class="inline-link hidden-link"
                                      href=<?php echo "'mailto:" . $mail . "'>" . $mail . "</a></div>"; ?>
                                      <a class="button button_grey pre-icon_calendar" href="#">Prendre rendez-vous</a>
            </div>
        </div>
    </div>