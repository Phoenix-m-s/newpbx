<?php global $member_info; ?>
<aside class="side-left transition" id="side-left">
    <ul class="sidebar">
        <?php

        global $company_info, $admin_info;
        ?>

        <?php if ($admin_info != -1) { ?>

            <li>
                <a href="<?php echo RELA_DIR . 'queue.php?action=showLiveQueue' ?>">
                    <i class="sidebar-icon fa fa-users"></i>
                    <span class="sidebar-text"><?php echo RIGHTMENU_37; ?></span> </a>
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