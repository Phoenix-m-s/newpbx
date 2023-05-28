<!DOCTYPE html>
<html lang="fa-IR"  dir="rtl">
<head>
    <meta charset="utf-8"/>
    <title> Zitel </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=1">
    <meta name="author" content="campaign">

    <link rel="stylesheet" type="text/css" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/print.css" media="print">
    <link rel="shortcut icon" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/images/favicon.png">
    <link rel="stylesheet" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/font-awesome.min.css">
    <link id="style-components" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/loaders.css" rel="stylesheet">
    <link id="style-components" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/bootstrap-theme.css" rel="stylesheet">
    <link id="style-components" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/dependencies.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/animate.min.css">
    <link id="style-base" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/style.css" rel="stylesheet">
    <link id="style-base" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/style-scss.css" rel="stylesheet">
    <link id="style-base" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/directional-ltr.css" rel="stylesheet">
    <!-- <link id="style-responsive" href="<?php /*echo RELA_DIR; */?>templates/<?php /*echo CURRENT_SKIN; */?>/assets/css/stilearn-responsive.css" rel="stylesheet">-->
    <link id="style-base" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/responsive.css" rel="stylesheet">
    <link id="style-helper" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/helper.css" rel="stylesheet">
    <link id="style-sample" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/pages-style.css" rel="stylesheet">
    <link id="style-sample" href="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/css/sweetalert2.min.css" rel="stylesheet">
    <!-- endbuild -->

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->

    <script src="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/js/jquery.js"></script>
    <script src="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/assets/js/scripts.js"></script>

    <script>
        $(document).ready(function () {
            $.httpRequest = function(url, method, data, hasFormData, isJson) {
                var option = {
                    url: url
                };

                if(method !== undefined && method !== null && method !== '') {
                    option.method = method;
                }

                if(data !== undefined && data !== null && data !== '') {
                    option.data = data;
                }

                if(hasFormData !== undefined && hasFormData === true) {
                    option.contentType = false;
                    option.processData = false;
                }

                if(isJson !== undefined && isJson === true) {
                    // option.contentType = "application/json; charset=utf-8";
                }

                return $.ajax(option);
            };
        });
    </script>

    <!-- Voice Recording Part -->
    <script src="../../media/js/recorder.js"></script>
    <script src="../../media/js/Fr.voice.js"></script>
    <script src="../../media/js/bootstrap.min.js"></script>
    <!--End of Voice recording files -->

</head>

<body>
<div class="spinnerContainer">
    <!-- loading -->
    <div class="spinner">
        <div class="spinner-container container1">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
            <div class="circle4"></div>
        </div>
        <div class="spinner-container container2">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
            <div class="circle4"></div>
        </div>
        <div class="spinner-container container3">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
            <div class="circle4"></div>
        </div>
    </div>
</div>
