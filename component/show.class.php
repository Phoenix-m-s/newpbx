<?php
class show{
    public function showAnnounce()
    {
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/announce.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl");

        die();
    }

    public function showExtension()
    {
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/extension.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl");

        die();
    }

    public function showUpload()
    {
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/upload.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl");

        die();
    }

    public function showIVR()
    {
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/IVR.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl");

        die();
    }

    public function showSIP()
    {
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/SIP.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl");

        die();
    }

    public function showQueue()
    {
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_start.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_header.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_rightMenu.tpl.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/queue.php");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_footer.tpl");
        include(ROOT_DIR . "templates/" . CURRENT_SKIN . "/template_end.tpl");

        die();
    }

}

