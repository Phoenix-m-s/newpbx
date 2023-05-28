<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
</head>
<script language="javascript" type="text/javascript">
    function postRefId (refIdValue) {
        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", "https://sep.shaparak.ir/Payment.aspx");
        form.setAttribute("target", "_self");

        var RedirectURL = document.createElement("input");
        RedirectURL.setAttribute("name", "RedirectURL");
        RedirectURL.setAttribute("value", "<?= RELA_DIR; ?>payment.php?action=returnBank");
        form.appendChild(RedirectURL);

        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("name", "Token");
        hiddenField.setAttribute("value", refIdValue);
        form.appendChild(hiddenField);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
</script>
<body>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center"><img src="<?=RELA_DIR?>templates/images/bank.png" width="42" height="34" /></td>
    </tr>
    <tr>
        <td align="center"><?=REPORT_28; ?></td>
    </tr>
    <tr>
        <td align="center"></td>
    </tr>
</table>
</body>
</html>
<?php echo "<script language='javascript' type='text/javascript'>postRefId('" . $resultToken['tokenResult'] . "');</script>";
exit() ;
die() ;
?>
