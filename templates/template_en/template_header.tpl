<!-- section header -->
<header class="header fixed">
    <?php
 global $member_info,$admin_info;
 if($admin_info != -1){
 $username = $admin_info['username'];
 }elseif($member_info != -1)
 {
  $username = $member_info['username'];
 }
 //print_r_debug($admin_info)?>
    <!-- header-profile -->
    <div class="header-profile">
        <div class="profile-nav dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown"> <span class="profile-username"><?php echo $username; ?></span>
                <i class="fa fa-angle-down"></i> </a>
            <ul class="dropdown-menu animated fadeInDown pull-right" role="menu">
                <?php /*<li>
                <a href="<?php echo RELA_DIR ?>userProfile.php" class="text-16"><i class="fa fa-user"></i><?=PROFILE; ?>
                </a></li>*/?>
                <li>
                    <?php
                    if ($admin_info != -1)
                    { ?>

                    <a href="<?php echo RELA_DIR ?>logout.php" class="text-16"><i class="fa fa-power-off"></i><?=SIGN_OUT; ?>
                    </a>
                    <?php } else {
                            ?>
                    <a href="<?php echo RELA_DIR ?>logout.php?type=user" class="text-16"><i
                                class="fa fa-power-off"></i><?= SIGN_OUT; ?>
                    </a>

                    <?php } ?>
                </li>
            </ul>
        </div>

        <?php
            $admin_id = $admin_info['admin_id'];
            $filename = ROOT_DIR."statics/adminPics/".$admin_id.'.jpg';
            $filename1= ROOT_DIR."statics/adminPics/".$admin_id.'.jpeg';
            $filename2= ROOT_DIR."statics/adminPics/".$admin_id.'.png';

            if(file_exists($filename))
            {
                $pic = $admin_id.'.jpg';
            }
            elseif (file_exists($filename1 ))
            {
                $pic = $admin_id.'.jpeg';

            }
            elseif(file_exists($filename2))
            {
                $pic = $admin_id.'.png';
            }
            else
            {
                $pic = 'No Image';
            }

            if($pic!='No Image')
            {
                ?>
        <div class="profile-picture">
            <img alt="me" src="<?php echo RELA_DIR.'statics/adminPics/'.$pic;?>" >
        </div>
        <?php
            }?>

    </div><!-- header-profile -->

    <div class="logoHolder" style="width: 120px;!important;">

        <a href="<?php echo RELA_DIR; ?>"><img src="<?php echo RELA_DIR;?>templates/<?php echo CURRENT_SKIN; ?>/images/logo.png">

        </a>

    </div>
    <div>
        <a href="changeLanguage.php?action=fa"><img width="40px" height="40px"  src="<?php echo RELA_DIR;?>templates/<?php echo CURRENT_SKIN; ?>/images/fa.png">

        </a>
        <a href="changeLanguage.php?action=en"><img width="40px" height="40px" src="<?php echo RELA_DIR;?>templates/<?php echo CURRENT_SKIN; ?>/images/en.png">

        </a>
    </div>
    <a id="toggleSideBar" class="hidden"> <span class="first"></span> <span class="second"></span> <span class="third"></span> </a>
</header><!--/header-->

<!-- content section -->
<section class="section">