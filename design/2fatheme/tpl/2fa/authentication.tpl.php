<?php if (isset($errors)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
    <a class="btn btn-default" href="<?php echo erLhcoreClassDesign::baseurl('user/login')?>">Login</a>
<?php else : ?>
<input type="hidden" id="twofahash" value="<?php echo $hash?>" />

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php foreach ($methods as $method) : $info = $method->getMethodInfo();?>
        <?php if (is_object($info)) : ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-<?php echo $method->method?>">
                <h4 class="panel-title">
                    <?php if (($img = $info->getImage()) != '') : ?>
                        <div class="col-xs-4">
                            <img class="img-respnsive" src="<?php echo $info->getImage()?>">
                        </div>
                    <?php endif; ?>
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $method->method?>" aria-expanded="true" aria-controls="collapse-<?php echo $method->method?>">
                        <?php echo htmlspecialchars($info->getTitle())?>
                    </a>
                </h4>
            </div>
            <div id="collapse-<?php echo $method->method?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-<?php echo $method->method?>">
                <div class="panel-body">
                    <?php echo $info->getBody($session); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>