<?php
include_once("server.inc.php");
include_once(ROOT_DIR . "common/db.inc.php");
include_once(ROOT_DIR . "common/init.inc.php");
include_once(ROOT_DIR . "common/func.inc.php");
include_once(ROOT_DIR . "component/db.inc.class.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>

    <?php
    global $company_info,$admin_info;

    ?>

    <script language="javascript" type="text/javascript">

        function postRefId () {
            var form = document.createElement("form");
            form.setAttribute("method", "POST");
            form.setAttribute("action", "http://payment.pbx.dabacenter.ir/");
            form.setAttribute("target", "_self");
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("name", "comp_name");
            hiddenField.setAttribute("value","<?=$company_info['comp_name']?>");
            form.appendChild(hiddenField);

            var s_temp = document.createElement("input");
            s_temp.setAttribute("name", "s_temp");
            s_temp.setAttribute("value","<?=$_SESSION["sessionID"];?>");
            form.appendChild(s_temp);


            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }


    </script>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
</head>

<body>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center"><!--<img src="<?php/*=RELA_DIR*/?>templates/images/bank.png" width="42" height="34" />--></td>
    </tr>
    <tr>
        <td align="center">???? ????? ??????</td>
    </tr>
    <tr>
        <td align="center"></td>
    </tr>
</table>
</body>

</html>
<script language="javascript" type="text/javascript">
    postRefId();
</script>