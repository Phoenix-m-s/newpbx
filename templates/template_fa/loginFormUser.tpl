<div class="content content-full">

    <div class="signin-brand">
        <a href="<?php echo RELA_DIR; ?>user.php">
            <img class="lazy center-block"
                 src="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/images/daba-logo-larg.png"
                 data-original="<?php echo RELA_DIR; ?>templates/<?php echo CURRENT_SKIN; ?>/images/daba-logo.jpg"
                 alt="Sign In">
        </a>
    </div>
    <div class="signin">
        <form action="<?php echo RELA_DIR; ?>user.php" method="POST" data-validate="form" role="form">
            <h2>PBX Administrator Login</h2>

            <div class="form-group">
                <div class="input-group input-group-in">
                    <span class="input-group-addon text-muted"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username"
                           autocomplete="off" autofocus="" spellcheck="false" required>
                </div><!--/input-group-->
            </div>

            <div class="form-group">
                <div class="input-group input-group-in">
                    <span class="input-group-addon text-mut
                    cdffed"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                           autocomplete="off" spellcheck="false" required>
                </div><!--/input-group-->
            </div>

            <div class="form-group">

                <select class="select2" name="type">
                    <?php
                    $server = constant("SERVER");
                    if (strlen($server) and $server == 'cloud') {
                       ?>
                    <option value="admin">Admin</option>
                    <?php
                    } ?>
                    <option value="member">Member</option>
                </select>
            </div>

            <div class="form-group form-actions">
                <input type="submit" class="btn btn-primary btn-default btn-block text-white text-16" value="Log In">
            </div>
            <input type="hidden" name="action" value="login"/>
        </form>
    </div>

    <div class="signin-footer center-block">
        <ul class="list-inline pull-right">
            <li><a href="#">Software Description</a></li>
            <li><a href="#">Rules</a></li>
            <li>&copy; 2014 Daba Center</li>
        </ul>
    </div>
    <!-- modalRecover -->
    <div class="modal fade" id="modalRecover" tabindex="-1" role="dialog" aria-labelledby="modalRecoverLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modalRecoverLabel">Reset Password</h4>
                </div>
                <div class="modal-body">
                    <form action="index.php" method="POST" data-validate="form" role="form" id="recover-form">
                        <div class="form-group">
                            <div class="input-group input-group-in">
                                <span class="input-group-addon text-muted">@</span>
                                <input type="email" class="form-control" name="recover" required autocomplete="off">
                            </div><!--/input-group-->
                        </div><!--/form-group-->
                        <p class="text-muted">
                            <small>Enter your username or email address and we will send you a link to reset your
                                password.
                            </small>
                        </p>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send reset link</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>