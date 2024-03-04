<div class="container">

    <h5><?php echo $provider['name']; ?></h5>
    <strong><?php echo $provider['irszam'] . ' ' . $provider['varos'] . '<br />'; ?>
        <?php echo $provider['utca'] . '<br />'; ?></strong>
    <?php echo 'Telefon: ' . $provider['mobil'] . '<br />'; ?>
    <?php
    if (strlen($provider['telefon']) > 5) {
        echo 'Telefon: ' . $provider['telefon'] . '<br />';
    }
    ?>
    <?php echo 'E-mail: ' . $provider['email'] . '<br />'; ?>
    <a href="<?php echo $provider['web']; ?>">Honlap</a><br />
    <?php echo 'Vezető: ' . $provider['vezeto']; ?>
    <div class="divider"></div>
    <div class="spacer"></div>

    <div><?php echo $provider['szoveg']; ?></div>
    <div class="divider"></div>
    <div class="spacer"></div>

    <?php foreach ($services as $serv) {   ?>

        <h6><?php echo $serv['servtitle']; ?></h6>
        <div><?php echo $serv['servcontent']; ?></div>
        <div class="divider"></div>
        <div class="spacer"></div>

    <?php } ?>

</div>