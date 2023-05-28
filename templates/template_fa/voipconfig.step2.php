<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"></a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <div class="content-body">
        <div class="mat-card mat-elevation-z3">
            <div class="mat-card-title">
                Step 2 -
            </div>

            <div class="mat-content">
                <div class="alert alert-warning" role="alert">
                    <p>Available Fields: </p>
                   <!-- <?php /*foreach ($export['headers'] as $header) : */?>
                        <span class="label label-primary margin-right"><?/*= '{' . $header . '}' . ' '*/?></span>
                    --><?php /*endforeach; */?>
                </div>

                <div class="alert alert-warning" role="alert">
                    <p>Rows: </p>
                  <!--  <?php /*foreach ($export['headers'] as $header) : */?>
                        <span class="label label-primary margin-right"><?php /*echo $header */?></span>
                    --><?php /*endforeach */?>
                    <hr>
                   <!-- <?php /*foreach ($export['rows'] as $row) : */?>
                        <span class="label label-primary margin-right"><?php /*echo implode($row, ', ') */?></span>
                        <br>
                        <br>
                    --><?php /*endforeach */?>
                </div>

                <div class="row no-margin">
                    <div class="col-xs-12 col-sm-8 col-md-8 center-block">
                        <form role="form" data-validate="form" class="form-horizontal" novalidate="novalidate" method="post">
                            <div class="mat-card-title mb-half no-padding">
                                Type your own email's html
                            </div>

                            <div class="form-group center-block mb-double">
                                <label for="subject">subject : </label>
                                <!--<input type="text" name="subject" id="subject" value="<?/*= strlen($export['data']['subject']) ? $export['data']['subject'] : ''; */?>">-->
                            </div>

                            <p>Please use <code>{f}</code> pattern for template binding variables in next step</p>

                            <div class="form-group center-block">
                                <?= $export['text'] ?>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="pull-right">
                                        <input name="step" type="hidden" value="3">
                                        <button type="submit" id="submit" class="btn mat-btn btn-success btn-block">
                                            Next step<i class="fa fa-angle-right"></i>
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </form>
                        <form action="" class="back-form" method="post" name="form1" id="form1" role="form" novalidate="novalidate" data-toggle="validator">
                            <input name="step" type="hidden" value="1">
                            <button name="step_2" type="submit" id="step2" class="btn mat-btn btn-danger">
                                <i class="fa fa-angle-left"></i>Back to step 1
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('.sidebar li:nth-child(2)').addClass('active');

            <?php if ($export['errors']) : ?>
            $.iziToastError('<?php echo $export['errors']['msg'] ?>');
            <?php endif; ?>
        })
    </script>