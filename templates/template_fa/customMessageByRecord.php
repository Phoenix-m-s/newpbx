<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 3/7/2017
 * Time: 8:36 AM
 */
?>

<div id='<?=$status?>' class='col-xs-12 col-sm-12' style='text-align: center;'>
    <input type="text" name="voiceTitle" class="form-control" id="voiceTitle<?=$recordId?>" title="Input the Voice Title" placeholder="Input The Voice Title" required>
    <audio controls src="" id="audio"></audio>
    <div class="row">
        <a class='<?=$status?> record' id='record_<?=$recordId?>' style='text-decoration: none'>
            <i class="fa fa-circle button" aria-hidden="true"></i>
        </a>
        <a class='disabled one record_<?=$recordId?>_one' id='pause' style='text-decoration: none'>
            <i class="fa fa-pause button" aria-hidden="true"></i>
        </a>
        <a class='disabled one record_<?=$recordId?>_one' id='play' style='text-decoration: none'>
            <i class="fa fa-play button" aria-hidden="true"></i>
        </a>
        <a class='disabled one record_<?=$recordId?>_one' id='save' style='text-decoration: none'>
            <i class="fa fa-upload button" aria-hidden="true"></i>
        </a>
    </div>
    <input class="button" type="checkbox" id="live"/>
    <label for="live">Live Output</label>
    <canvas id='record_<?=$recordId?>_level' height='100' width='200'></canvas>
    <div id="lightBox" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <img src="" alt="" class="img-responsive center-block">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>