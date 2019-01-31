<?php if (isset($errors)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
    <a class="btn btn-secondary" href="<?php echo erLhcoreClassDesign::baseurl('user/login')?>">Login</a>
<?php else : ?>
<input type="hidden" id="twofahash" value="<?php echo $hash?>" />

<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
    <?php foreach ($methods as $method) : $info = $method->getMethodInfo();?>
        <?php if (is_object($info)) : ?>
        <div class="card">
            <div class="card-header" role="tab" id="heading-<?php echo $method->method?>">
                <h6 class="card-title mb-0">
                    <?php if (($img = $info->getImage()) != '') : ?>
                        <div class="col-4">
                            <img class="img-fluid" src="<?php echo $info->getImage()?>">
                        </div>
                    <?php endif; ?>
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $method->method?>" aria-expanded="true" aria-controls="collapse-<?php echo $method->method?>">
                        <?php echo htmlspecialchars($info->getTitle())?>
                    </a>
                </h6>
            </div>
            <div id="collapse-<?php echo $method->method?>" class="card-collapse collapse<?php ($method->default == 1) ? print ' show' : ''?>" role="tabpanel" aria-labelledby="heading-<?php echo $method->method?>">
                <div class="card-body">
                    <?php echo $info->getBody($session, $method); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>