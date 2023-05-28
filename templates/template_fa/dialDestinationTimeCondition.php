<?php
//
//
?>
<select name='<?=$forward?>' class='<?=$class?>' required>

    <?php foreach ($extensionClean as $value) { ?>
        <option value='<?=$value['id']?>'>
            <?=$value['name']?>
        </option>
    <?php } ?>
</select>
<input type='hidden' value='' name='<?=$dstOption?>'>

<?php if (!empty($subDst) and isset($subDst)) { ?>
    <input type='hidden' value='' name='<?=$subDst?>'>
<?php } ?>

