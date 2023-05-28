<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 3/15/2017
 * Time: 2:33 PM
 */
?>
<input type='hidden' value='' name='<?=$forward?>'>
<input type='hidden' value='' name='<?=$dstOption?>'>

<?php if (!empty($subDst) and isset($subDst)) { ?>
    <input type='hidden' value='' name='<?=$subDst?>'>
<?php } ?>