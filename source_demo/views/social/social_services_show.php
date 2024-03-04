<div class="container">

  <ul class="collapsible">
    <li>
      <div class="collapsible-header">
        <?php echo '<h6>' . $provider['name'] . '</h6>'; ?></div>
      <div class="collapsible-body"><span>
          <strong><?php echo $provider['irszam'] . ' ' . $provider['varos'] . '<br />'; ?>
            <?php echo $provider['utca'] . '<br />'; ?></strong>
          <?php echo 'Telefon: ' . $provider['mobil'] . '<br />'; ?>
          <?php
          if (strlen($provider['telefon']) > 5) {
            echo 'Telefon: ' . $provider['telefon'] . '<br />';
          }
          ?>
          <?php echo 'E-mail: ' . $provider['email'] . '<br /><br />'; ?>

          <a href="<?php echo base_url(); ?>index.php/social_provider_card/<?php echo $provider['provid']; ?>">
            <p>Részletes információ<p>
          </a>
        </span></div>
    </li>
  </ul>

  <p><strong> <?php echo $service['servtitle']; ?></strong></p>
  <div><?php echo $service['servcontent']; ?></div>

  <div class="spacer"></div>

</div>