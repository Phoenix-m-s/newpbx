<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 3/15/2017
 * Time: 2:32 PM
 */
?>

<select name='<?=$forward?>' class='<?=$class?>' required>
    <?php foreach ($IVRListClean as $value) { ?>
        <option value='<?=$value->ivr_id?>' selected>
            <?=$value->ivr_name?>
        </option>
    <?php } ?>
</select>

<input type='hidden' value='' name='<?=$dstOption?>'>

<?php if (!empty($subDst) and isset($subDst)) { ?>
    <input type='hidden' value='' name='<?=$subDst?>'>
<?php } ?>
