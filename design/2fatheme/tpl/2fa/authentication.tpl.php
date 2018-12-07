<p><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('2fa/admin','Choose 2FA method')?></p>

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
                    <?php echo $info->getBody(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>