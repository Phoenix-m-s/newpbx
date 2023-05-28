<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 4/16/2017
 * Time: 4:01 PM
 */
//print_r_debug($extensionList);
?>
<select name='<?=$name?>' required>
    <?php foreach ($extensionList as $key => $value) { ?>
    <option value='<?=$key?>'><?=$value?></option>
    <?php } ?>
</select>
