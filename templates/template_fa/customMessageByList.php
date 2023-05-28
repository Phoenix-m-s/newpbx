<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 3/15/2017
 * Time: 12:19 PM
 */
?>

<select name='<?=$name?>' required>
    <?php foreach ($voiceClean as $key => $value) { ?>
    <option value='<?=$key?>'>
        <?=$value?>
    </option>
    <?php } ?>
</select>