<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 3/15/2017
 * Time: 1:57 PM
 */
?>
<select name='<?=$name?>'  class='<?=$name?>' required>";
    <?php foreach ($extensionClean as $key => $value) { ?>
    <option value="<?=$value[ 'extension_id' ]?>">
        <?=$value['extension_name']?>
    </option>
    <?php } ?>
</select>
