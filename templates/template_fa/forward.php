<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 3/15/2017
 * Time: 2:32 PM
 */
?>

<select name='<?=$name?>' class='<?=$class?>' required>
    <option>Choose</option>
    <option value='internal'>Internal</option>
    <option value='external'>External</option>
</select>
<?php if (!empty($subDst) and isset($subDst)) { ?>
    <input type='hidden' value='' name='<?=$subDst?>'>
<?php } ?>