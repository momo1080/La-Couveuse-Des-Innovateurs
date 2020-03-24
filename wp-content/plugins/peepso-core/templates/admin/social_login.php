<style>
    .sociallogin__admin {
        margin-top: 30px;
        padding-left: 13px;
    }

    .sociallogin__admin > .box {
        background: #fff;
        padding: 20px;
        margin-bottom: 10px;
        border: 2px solid rgba(0,0,0, .1);
    }

    .sociallogin__admin > .box .box-label {
        margin-top: 5px;
    }
</style>

<div class="row sociallogin__admin">
    <?php foreach ($social_login_fields as $social_login_field) : ?>
        <?php
        $dropdown = '<option value="0">' . __("-- Select field --", 'peepso-core') . '</option>';
        foreach ($fields as $field) {
            if (isset($option[$social_login_field]) && $option[$social_login_field] == $field->id) {
                $selected = ' selected';
            } else {
                $selected = '';
            }
            $dropdown .= '<option value="' . $field->id . '"' . $selected . '>' . $field->title . '</option>';
        }
        ?>
        <div class="box">
            <div class="col-md-3 box-label"><?php echo ucwords(str_replace('_', ' ', $social_login_field)); ?></div>
            <div class="col-md-3">
                <select class="form-control field" data-field="<?php echo $social_login_field; ?>">
                    <?php echo $dropdown; ?>
                </select>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endforeach; ?>

    <div class="box">
        <div class="clearfix"></div>
        <div class="col-md-3 box-label"><?php echo __('Import avatar', 'peepso-core'); ?></div>
        <div class="col-md-3">
            <?php
            $import_avatar = PeepSo::get_option('social_login_import_avatar', 1);
            ?>
            <select class="form-control field" data-field="avatar">
                <option value="1"<?php echo ($import_avatar == 1) ? ' selected' : ''; ?>><?php echo __('Yes', 'peepso-core'); ?></option>
                <option value="0"<?php echo ($import_avatar == 0) ? ' selected' : ''; ?>><?php echo __('No', 'peepso-core'); ?></option>
            </select>
        </div>
        <div class="clearfix"></div>
    </div>
</div>