<?php global $member_info; ?>
<aside class="side-left transition" id="side-left">
    <ul class="sidebar">
        <?php

        global $company_info,$admin_info;
        ?>

        <?php
        if($company_info !=-1 and $company_info['reload_alert']==1): ?>
        <li>
            <a id="reload">
                <img id="loading" src="<?php echo RELA_DIR;?>templates/<?php echo CURRENT_SKIN; ?>/images/ajaxloader.gif">
                <i class="sidebar-icon fa fa-refresh text-danger"></i>
                <span class="sidebar-text"><?php echo RIGHTMENU_01; ?></span>
            </a>
        </li>
        <?php endif ?>

<?php if ($admin_info != -1) { ?>

        <li>
            <a href="<?php echo RELA_DIR.'loginAs.php?action=loginas'?>">
                <i class="sidebar-icon fa fa-lock"></i>
                <span class="sidebar-text"><?php echo RIGHTMENU_02; ?></span>
            </a>
        </li>

        <?php
        if($company_info !=-1 and $admin_info['loginAs']!=''): ?>
        <li>
            <a href="<?php echo RELA_DIR.'loginAs.php?action=return'?>">
                <i class="sidebar-icon fa fa-long-arrow-right"></i>
                <span class="sidebar-text"><?php echo RIGHTMENU_03; ?></span>
            </a>
        </li>
        <?php endif ?>

        <li>
            <a href="<?php print RELA_DIR; ?>index.php">
                <i class="sidebar-icon fa fa-home"></i>
                <span class="sidebar-text"><?php echo INDEX_001; ?></span>
            </a>
        </li>

        <li>
            <a class="hasMenu" id="pbx-tel">
                <i class="sidebar-icon fa fa-cloud"></i>
                <span class="sidebar-text"><?php echo RIGHTMENU_04; ?></span>
                <b class="fa fa-angle-down transition"></b>
            </a>
            <ul class="sidebar-child animated fadeInDown admin-package-child">
                <li>
                    <a href="<?php echo RELA_DIR.'announce.php?action=showAnnounce'?>" class="">
                        <i class="sidebar-icon fa fa-file-sound-o"></i>
                        <span class="sidebar-text"><?php echo ANNOUNCE_01; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'mainTimeCondition.php'?>">
                        <i class="fa fa-clock-o sidebar-icon"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_36; ?></span>
                    </a>
                </li>
                <li>
                    <?php
                     global $member_info;
                     if($member_info == -1) { ?>
                        <a href="<?php echo RELA_DIR.'extension.php?action=showExtensions'?>">
                            <i class="sidebar-icon fa fa-phone"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_05; ?></span>
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo RELA_DIR.'extension.php?action=editExtension&id='.$member_info['extension_id']?>">
                            <i class="sidebar-icon fa fa-phone"></i>
                            <span class="sidebar-text"><?php echo RIGHTMENU_05; ?></span>
                        </a>
                    <?php } ?>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'upload.php?action=showUploads'?>">
                        <i class="sidebar-icon fa fa-file"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_06; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'ivr.php?action=showIvr'?>">
                        <i class="sidebar-icon fa fa-phone-square"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_07; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'queue.php?action=showQueues'?>">
                        <i class="sidebar-icon fa fa-users"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_08; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'sip.php?action=showSip'?>">
                        <i class="sidebar-icon fa fa-gear"></i>
                        <span class="sidebar-text"><?php echo OUTBOUND_05; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'inbound.php?action=showInbound'?>">
                        <i class="sidebar-icon fa fa-arrow-circle-o-left"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_09; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'outbound.php?action=showOutbound'?>">
                        <i class="sidebar-icon fa fa-arrow-circle-o-right"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_10; ?></span>
                    </a>
                </li>
                <li class="sub-menu2">
                    <a class="hasMenu2">
                        <i class="sidebar-icon fa fa-shopping-cart"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_10; ?></span>
                        <b class="fa fa-angle-down transition"></b>
                    </a>
                    <ul class="sidebar-child animated fadeInDown package-child">
                        <li>
                            <a href="<?php echo RELA_DIR.'package.php?action=showCompanyPackage'?>">
                                <span class="sidebar-text"><?php echo RIGHTMENU_11; ?></span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo RELA_DIR.'package.php?action=buyPackage'?>">
                                <span class="sidebar-text"><?php echo RIGHTMENU_12; ?></span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo RELA_DIR.'packageLog.php?action=showAllPackageLog'?>">
                                <span class="sidebar-text"><?php echo RIGHTMENU_13; ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sub-menu2">
                    <a class="hasMenu2">
                        <i class="sidebar-icon fa fa-bar-chart"></i>
                        <span class="sidebar-text"><?php echo RIGHTMENU_14; ?></span>
                        <b class="fa fa-angle-down transition"></b>
                    </a>
                    <ul class="sidebar-child animated fadeInDown report-child">
                        <li>
                            <a href="<?php echo RELA_DIR.'report.php?action=showReport'?>">
                                <span class="sidebar-text"><?php echo RIGHTMENU_15; ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo RELA_DIR.'report.php?action=showPaymentReport'?>">
                                <span class="sidebar-text"><?php echo RIGHTMENU_16; ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <li>
            <a class="hasMenu">
                <i class="sidebar-icon fa fa-yelp"></i>
                <span class="sidebar-text"><?php echo RIGHTMENU_17; ?></span>
                <b class="fa fa-angle-down transition"></b>
            </a>
            <ul class="sidebar-child animated fadeInDown campaign-child">
                <li>
                    <a href="<?php print RELA_DIR; ?>campaign.php">
                        <span class="sidebar-text"><?php echo RIGHTMENU_18; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php print RELA_DIR; ?>groupSchedule.php">
                        <span class="sidebar-text"><?php echo RIGHTMENU_19; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php print RELA_DIR; ?>blackList.php">
                        <span class="sidebar-text"><?php echo RIGHTMENU_20; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php print RELA_DIR; ?>numbers.php">
                        <span class="sidebar-text"><?php echo RIGHTMENU_21; ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="<?php echo RELA_DIR.'admin.list.php'?>">
                <i class="sidebar-icon fa fa-user"></i>
                <span class="sidebar-text"><?php echo RIGHTMENU_22; ?></span>
            </a>
        </li>

        <li>
            <a class="hasMenu">
                <i class="sidebar-icon fa fa-university"></i>
                <span class="sidebar-text"><?php echo RIGHTMENU_23; ?></span>
                <b class="fa fa-angle-down transition"></b>
            </a>
            <ul class="sidebar-child animated fadeInDown company-child">
                <li>
                    <a href="<?php echo RELA_DIR.'company.php?action=addCompany'?>">
                        <span class="sidebar-text"><?php echo RIGHTMENU_24; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'company.php?action=showCompanies'?>">
                        <span class="sidebar-text"><?php echo RIGHTMENU_25; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'company.php?action=addCompanyGroup'?>">
                        <span class="sidebar-text"><?php echo RIGHTMENU_26; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'company.php?action=showCompanyGroups'?>">
                        <span class="sidebar-text"><?php echo RIGHTMENU_27; ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a class="hasMenu">
                <i class="sidebar-icon fa fa-dollar"></i>
                <span class="sidebar-text"><?php echo RIGHTMENU_28; ?></span>
                <b class="fa fa-angle-down transition"></b>
            </a>
            <ul class="sidebar-child animated fadeInDown admin-package-child">
                <li>
                    <a href="<?php echo RELA_DIR.'admin.package.php?action=addPackage'?>">
                        <span class="sidebar-text"><?php echo RIGHTMENU_28; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'admin.package.php?action=showPackage'?>">
                        <span class="sidebar-text"><?php echo RIGHTMENU_29; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'admin.package.php?action=addGroupPackage'?>">
                        <span class="sidebar-text"><?php echo RIGHTMENU_30; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'admin.package.php?action=showGroupPackage'?>">
                        <span class="sidebar-text"><?php echo RIGHTMENU_31; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'admin.package.php?action=addPackageToCompany'?>">
                        <span class="sidebar-text"><?php echo RIGHTMENU_32; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'admin.package.php?action=addGroupPackageToCompany'?>">
                        <span class="sidebar-text"><?php echo RIGHTMENU_33; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo RELA_DIR.'admin.package.php?action=removeGroupPackageFromCompany'?>">
                        <span class="sidebar-text"><?php echo RIGHTMENU_34; ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="<?php echo RELA_DIR.'guide.php?action=showGuide'?>">
                <i class="sidebar-icon fa fa-question"></i>
                <span class="sidebar-text"><?php echo RIGHTMENU_35; ?></span>
            </a>
        </li>

        <?php } elseif ($member_info != -1) { ?>

        <li>
            <a href="<?php print RELA_DIR; ?>index.php">
                <i class="sidebar-icon fa fa-home"></i>
                <span class="sidebar-text"><?php echo INDEX_001; ?></span>
            </a>
        </li>

        <li>
            <a href="<?= RELA_DIR.'extension.php?action=editExtension&id='.$member_info['extension_id']?>">
                <i class="sidebar-icon fa fa-phone"></i>
                <span class="sidebar-text"><?php echo RIGHTMENU_05; ?></span>
            </a>
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
            $.ajax
            ({
                type: 'POST',
                url: 'reload.php',
                success: function () {
                    $("#reload").hide();
                    $("#loading").hide();
                }
            });
        });
    });

</script>