<div class="container" style="background-image: url(<?php echo $szocBasePath; ?>kozos/human-bg.jpg)">
  <div class="col s12 pad-0">
    <h5 class="bot-20 sec-tit  ">DOKUMENTUMOK</h5>
    <ul class="collapsible">
      <?php foreach ($providers as $prov) { ?>
        <li>
          <div class="collapsible-header">
            <i class="col col-1 waves-effect waves-light btn-small bg-primary mdi mdi-file-document"></i>
            <?php echo $prov['name']; ?>
          </div>
          <?php foreach ($documents as $docs) {
            if ($docs['provid'] === $prov['provid']) {
          ?>
              <div class="collapsible-body">
                <a href="<?php echo base_url(); ?>index.php/social_documents_send/<?php echo $docs['docid']; ?>" class="waves-effect waves-light btn-small bg-primary mdi mdi-email-outline"></a>&nbsp;&nbsp;
                <?php echo $docs['doctitle']; ?></a>
              </div>
          <?php } // end of if 
          } // end of foreach
          ?>
        </li>
      <?php } // end of foreach 
      ?>
    </ul>
  </div>
</div><?php // container 
      ?>