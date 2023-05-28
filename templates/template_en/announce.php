<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 3/15/2017
 * Time: 2:33 PM
 */

?>
<select name='<?=$forward?>' class='<?=$class?>' required>
    <?php foreach ($announceListClean as $value) { ?>
        <option value='<?=$value->announce_id?>' selected>
            <?=$value->announce_name?>
        </option>
    <?php } ?>
</select>
<input type='hidden' value='' name='<?=$dstOption?>'>

<?php if (!empty($subDst) and isset($subDst)) { ?>
    <input type='hidden' value='' name='<?=$subDst?>'>
<?php } ?>

