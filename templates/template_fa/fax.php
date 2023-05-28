<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 3/15/2017
 * Time: 2:33 PM
 */
?>

<input type='text' class='form-control' name='<?=$forward?>' id='fax' placeholder='Enter Phone Number'>
<input type='hidden' value='' name='<?=$dstOption?>'>

<?php if (!empty($subDst) and isset($subDst)) { ?>
    <input type='hidden' value='' name='<?=$subDst?>'>
<?php } ?>