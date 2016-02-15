<?php
include("langVars.php");
$catchPhraseLength = strlen($catchPhrase);
$middleIndex = (int)floor(strlen($catchPhrase) / 2);
$leftIterator = $middleIndex;
$rightIterator = $middleIndex;
$foundedIndex = -1;

//Search for the first space from the middle of the word to cut it
while ($foundedIndex == -1 && ($leftIterator >= 0 || $rightIterator < $catchPhraseLength)) {
    if ($leftIterator >= 0) {
        if ($catchPhrase[$leftIterator] == ' ') {
            $foundedIndex = $leftIterator;
        } else {
            $leftIterator--;
        }
    }
    if ($rightIterator < $catchPhraseLength) {
        if ($catchPhrase[$rightIterator] == ' ') {
            $foundedIndex = $rightIterator;
        } else {
            $rightIterator++;
        }
    }
}
if ($foundedIndex != -1) {
    $catchPhrase = "<div>" . substr($catchPhrase, 0, $foundedIndex + 1) . "</div><div class='bold'>" . substr($catchPhrase, $foundedIndex + 1) . "</div>";
} else {
    $catchPhrase = "<div>" . $catch . "</div>";
}

?>
<div class="cont">
    <?php
    echo '<img src="/content/' . $catchImage . '" alt="Image d\'accroche">';
    ?>
    <div class="topText">
        <?php
        echo $catchPhrase;
        ?>
    </div>
    <div class="buttons">
        <a class="button button_white pre-icon_call"
           href="http://www.docteur-virag-sexologie.fr/appointment"><?php echo $contactus; ?></a>
        <a class="button button_white" href="#"><?php echo $testyourself; ?></a>
    </div>
</div>
