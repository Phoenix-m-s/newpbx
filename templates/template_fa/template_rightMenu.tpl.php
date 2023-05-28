<?php global $member_info, $admin_info, $company_info; ?>
<?php if ($admin_info['type'] != 2) : ?>
    <aside class="side-left transition" id="side-left">
        <ul class="sidebar">

            <?php
            if ($company_info != -1 and $company_info['reload_alert'] == 1): ?>
                <li>
                    <a id="reload">
                        <img id="loading" src="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/images/ajaxloader.gif">
                        <i class="sidebar-icon fa fa-refresh text-danger"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_01; ?></span> </a>
                </li>
            <?php endif ?>

            <?php if ($admin_info != -1) { ?>

                <?php
                if ($company_info != -1 and $admin_info['loginAs'] != ''): ?>
                    <li>
                        <a href="<?php echo RELA_DIR . 'loginAs.php?action=return' ?>">
                            <i class="sidebar-icon fa fa-long-arrow-right"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_03; ?></span> </a>
                    </li>
                <?php endif ?>
                <li>
                    <a href="<?php echo RELA_DIR . 'loginAs.php?action=loginas' ?>">
                        <i class="sidebar-icon fa fa-long-arrow-right"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_03; ?></span> </a>
                </li>
                <li>
                    <a href="<?php print RELA_DIR; ?>index.php"> <i class="sidebar-icon fa fa-home"></i>
                        <span class="sidebar-text"><?php echo INDEX_001; ?></span> </a>
                </li>

                <li>

                    <a href="<?php echo RELA_DIR . 'announce.php?action=showAnnounce' ?>" class="">
                        <i class="sidebar-icon fa fa-file-sound-o"></i>
                        <span class="sidebar-text"><?php echo INDEX_011; ?></span> </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR . 'mainTimeCondition.php' ?>"> <i class="fa fa-clock-o sidebar-icon"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_36; ?></span> </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR . 'extension.php?action=showExtensions' ?>">
                        <i class="sidebar-icon fa fa-phone"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_05; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR . 'upload.php?action=showUploads' ?>">
                        <i class="sidebar-icon fa fa-play-circle-o"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_06; ?></span> </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR . 'ivr.php?action=showIvr' ?>">
                        <i class="sidebar-icon fa fa-list-ol"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_07; ?></span> </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR . 'queue.php?action=showQueues' ?>">
                        <i class="sidebar-icon fa fa-sort-amount-desc"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_08; ?></span> </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR . 'sip.php?action=showSip' ?>"> <i class="sidebar-icon fa fa-gear"></i>
                        <span class="sidebar-text"><?php echo OUTBOUND_05; ?></span> </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR . 'inbound.php?action=showInbound' ?>">
                        <i class="sidebar-icon fa fa-sign-in fa-rotate-180"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_09; ?></span> </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR . 'outbound.php?action=showOutbound' ?>">
                        <i class="sidebar-icon fa fa-sign-in"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_10; ?></span> </a>
                </li>

                <li>
                    <a href="<?php echo RELA_DIR . 'report.php?action=showReport' ?>">
                        <i class="sidebar-icon fa fa-bar-chart"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_14; ?></span> </a>
                </li>

                <li>
                    <a href="<?php echo RELA_DIR . 'admin.list.php' ?>"> <i class="sidebar-icon fa fa-user"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_22; ?></span> </a>
                </li>
                <li>
                    <a href="<?= RELA_DIR . 'voipconfig.php?action=stepform'; ?>">
                        <i class="sidebar-icon fa fa-phone"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_37; ?></span> </a>
                </li>
                <!--                {************** confrence menu add by Sakhamanesh&jahanbakhsh ******************}-->
                <li>
                    <a href="<?php echo RELA_DIR . 'conference.php?action=showConference' ?>">
                        <i class="sidebar-icon fa fa-users"></i>
                        <span class="sidebar-text">
                            <?php echo RIGHTMENU_38; ?>
                        </span>
                    </a>
                </li>

           <?php } elseif ($member_info != -1) { ?>

                <li>
                    <a href="<?php print RELA_DIR; ?>index.php"> <i class="sidebar-icon fa fa-home"></i>
                        <span class="sidebar-text"><?php echo INDEX_001; ?></span> </a>
                </li>

                <li>
                    <a href="<?= RELA_DIR . 'extension.php'; ?>">
                        <i class="sidebar-icon fa fa-phone"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_05; ?></span> </a>
                </li>
    <!--     add by Jahanbakhsh       -->
                <li>
                    <a href="<?= RELA_DIR . 'conference.php'; ?>">
                        <i class="sidebar-icon fa fa-users"></i>
                        <span class="sidebar-text">
                            <?php echo RIGHTMENU_38; ?>
                        </span>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR . 'report.php?action=showReport' ?>">
                        <i class="sidebar-icon fa fa-bar-chart"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_14; ?></span> </a>
                </li>

            <?php } ?>

        </ul>

    </aside>

    <div class="side-overlay">

    </div>

    <script type="text/javascript" language="javascript" class="init">

        $(document).ready(function () {
            $("#loading").hide();
            $("#reload").click(function () {
                $("#loading").show();
                $.ajax({
                    type: 'POST',
                    url: 'reload.php',
                    success: function () {
                        $("#reload").parent().remove();
                        $("#loading").hide();
                    }
                });
            });
        });

    </script>
<?php else: ?>
    <?php include ROOT_DIR . 'templates/template_en/template_rightMenu_queueMonitoring.tpl.php' ?>
<?php endif; ?>
