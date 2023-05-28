<?php global $member_info, $admin_info, $company_info;
$listMenu = checkDisplayUi();
?>
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

                <?php endif ?>
                <?php if($listMenu['loginAs']!=0){?>
                    <li>
                        <a href="<?php echo RELA_DIR . 'loginAs.php?action=loginas' ?>">
                            <i class="sidebar-icon fa fa-long-arrow-right"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_03; ?></span> </a>
                    </li>

                <?php } ?>

                <li>
                    <a href="<?php print RELA_DIR; ?>index.php"> <i class="sidebar-icon fa fa-home"></i>
                        <span class="sidebar-text"><?php echo INDEX_001; ?></span> </a>
                </li>

                <?php  if($listMenu['SuperAdmin']!=0){?>
                    <li>
                        <a class="hasMenu"> <i class="sidebar-icon fa fa-user"></i>
                            <span class="sidebar-text"><?php echo INDEX_012; ?></span>
                            <b class="fa fa-angle-down transition"></b>
                        </a>
                        <ul class="sidebar-child animated fadeInDown company-child">
                            <?php if($listMenu['trunk']!=0){?>
                                <li>
                                    <a href="<?php echo RELA_DIR . 'trunk.php?action=showTrunk' ?>"> <i class="sidebar-icon fa fa-volume-control-phone"></i>
                                        <span class="sidebar-text"><?php echo OUTBOUND_27; ?></span> </a>
                                </li>
                            <?php }
                            if($listMenu['routing']!=0){?>
                                <li>
                                    <a href="<?php echo RELA_DIR . 'routing.php?action=showRouting' ?>"> <i class="sidebar-icon fa fa-random"></i>
                                        <span class="sidebar-text"><?php echo OUTBOUND_28; ?></span> </a>
                                </li>
                            <?php }

                            if($listMenu['company']!=0){?>
                                <li>
                                    <a href="<?php echo RELA_DIR . 'company.php' ?>">
                                        <i class="sidebar-icon fa fa-building-o "></i>
                                        <span class="sidebar-text"><?php echo EXTENSION_12; ?></span> </a>
                                </li>

                            <?php }?>

                        </ul>
                    </li>
                <?php  }if($listMenu['announce']!=0){?>
                    <li>

                        <a href="<?php echo RELA_DIR . 'announce.php?action=showAnnounce' ?>" class="">
                            <i class="sidebar-icon fa fa-file-sound-o"></i>
                            <span class="sidebar-text"><?php echo INDEX_011; ?></span> </a>
                    </li>
                <?php } if($listMenu['mainTimeCondition']!=0){?>
                    <li>
                        <a href="<?php echo RELA_DIR . 'mainTimeCondition.php' ?>"> <i class="fa fa-clock-o sidebar-icon"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_36; ?></span> </a>
                    </li>
                <?php } ?>
                <?php if($listMenu['extension']!=0){?>
                    <li>
                        <a href="<?php echo RELA_DIR . 'extension.php?action=showExtensions' ?>">
                            <i class="sidebar-icon fa fa-phone"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_05; ?></span>
                        </a>
                    </li>
                <?php }if($listMenu['upload']!=0){?>
                    <li>
                        <a href="<?php echo RELA_DIR . 'upload.php?action=showUploads' ?>">
                            <i class="sidebar-icon fa fa-play-circle-o"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_06; ?></span> </a>
                    </li>
                <?php }if($listMenu['ivr']!=0){?>
                    <li>
                        <a href="<?php echo RELA_DIR . 'ivr.php?action=showIvr' ?>">
                            <i class="sidebar-icon fa fa-list-ol"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_07; ?></span> </a>
                    </li>
                <?php }if($listMenu['queue']!=0){?>
                    <li>
                        <a href="<?php echo RELA_DIR . 'queue.php?action=showQueues' ?>">
                            <i class="sidebar-icon fa fa-users"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_08; ?></span> </a>
                    </li>
                <?php }if($listMenu['sip']!=0){?>
                    <li>
                        <a href="<?php echo RELA_DIR . 'sip.php?action=showSip' ?>"> <i class="sidebar-icon fa fa-gear"></i>
                            <span class="sidebar-text"><?php echo OUTBOUND_05; ?></span> </a>
                    </li>
                <?php }
                if($listMenu['inbound']!=0){?>
                    <li>
                        <a href="<?php echo RELA_DIR . 'inbound.php?action=showInbound' ?>">
                            <i class="sidebar-icon fa fa-sign-in fa-rotate-180"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_09; ?></span> </a>
                    </li>
                <?php }
                if($listMenu['report']!=0){?>
                    <li>
                        <a href="<?php echo RELA_DIR . 'report.php?action=showReport' ?>">
                            <i class="sidebar-icon fa fa-bar-chart"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_14; ?></span> </a>
                    </li>

                <?php }
                if($listMenu['outbound']!=0){?>
                    <li>
                        <a href="<?php echo RELA_DIR . 'outbound.php?action=showOutbound' ?>">
                            <i class="sidebar-icon fa fa-sign-in"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_10; ?></span> </a>
                    </li>
                <?php }
                if($listMenu['adminList']!=0){
                    ?>

                    <li>
                        <a href="<?php echo RELA_DIR . 'admin.list.php' ?>"> <i class="sidebar-icon fa fa-user"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_22; ?></span> </a>
                    </li>
                <?php }if($listMenu['voipconfig']!=0){?>
                    <li>
                        <a href="<?= RELA_DIR . 'voipconfig.php?action=stepform'; ?>">
                            <i class="sidebar-icon fa fa-phone"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_37; ?></span>
                        </a>
                    </li>
                <?php } if($listMenu['conference']!=0){?>
                    <!--                {************** confrence menu add by Sakhamanesh&jahanbakhsh ******************}-->
                    <li>
                        <a href="<?php echo RELA_DIR . 'conference.php?action=showConference' ?>">
                            <i class="sidebar-icon fa fa-video-camera"></i>
                            <span class="sidebar-text">
                            <?php echo RIGHTMENU_38; ?>
                        </span>
                        </a>
                    </li>


                <?php } //if($listMenu['record']!=0){?>
                <!--                {************** confrence menu add by Sakhamanesh&jahanbakhsh ******************}-->

                <?php  if($listMenu['record']!=0){?>
                    <li>
                        <a href="<?php echo RELA_DIR . 'record.php' ?>">
                            <i class="sidebar-icon fa fa-video-camera"></i>
                            <span class="sidebar-text">
                            <?php echo RIGHTMENU_39; ?>
                    </span>
                        </a>
                    </li>

                <?php } ?>
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
