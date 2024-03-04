<div class="container">
    <div class="section">

        <div class="col s12 pad-0">
            <h5 class="bot-20 sec-tit  "><?php echo $pagetitle; ?> </h5>
            <div>
                <form class="" action="<?php echo $base_url . 'index.php/admin_kozlemeny_edit/' . $adat['app']; ?>" method="post">

                    <div class="col s12">
                        <label for="title">Közlemény címe: </label>
                        <input type="text" autofocus value="<?php echo $adat['title']; ?>" name="title" class="" id="title">
                    </div>


                    <div class="col s12">
                        <label for="kozlemeny">Közlemény:</label>
                        <textarea id="kozlemeny" name="kozlemeny" rows="4" cols="50"><?php echo $adat['kozlemeny']; ?></textarea>
                    </div>

                    <!-- Switch -->
                    <div class="switch large">
                        <p>Aktív:</p>
                        <label>
                            Nem
                            <input name="aktiv" type="checkbox" <?php if ($adat['aktiv'] === "Y") {
                                                                    echo ' checked ';
                                                                } ?>>
                            <span class="lever"></span>
                            Igen (megjelenik a felhasználóknál)
                        </label>
                    </div>

            </div><?php // row 
                    ?>

            <div class="divider"></div>
            <div class="spacer"></div>


            <div class="row">
                <input type="hidden" name="id" value="<?php echo $adat['id']; ?>" />
                <input type="hidden" name="datum" value="<?php echo $adat['datum']; ?>" />
                <input type="hidden" name="app" value="<?php echo $adat['app']; ?>" />

                <div class="col s4 pad-0">
                    <button class="btn waves-effect waves-light green lighten-1" type="submit" name="btn_submit" value="ok">
                        <?php if ($adat['id'] === '0') {
                            echo 'Létrehozás';
                        } else {
                            echo 'Módosítás';
                        } ?>
                        <i class="mdi mdi-square-edit-outline right"></i></button>
                </div>

                <div class="col s4 pad-0">
                    <button class="btn waves-effect waves-light bg-primary" type="cancel" name="btn_cancel" value="cancel">
                        MÉGSEM<i class="mdi mdi-cancel right"></i></button>
                </div>

            </div><?php // torol 
                    ?>
        </div><?php // row 
                ?>

        </form>
    </div>
</div><?php // section 
        ?>
</div><?php // container 
        ?>