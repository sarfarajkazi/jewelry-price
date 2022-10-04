<div class="wrap property-imports">
    <div id="poststuff wrap">
        <div id="post-body" class="metabox-holder columns-2">
            <div id="post-body-content"><?php settings_errors(); ?>
                <form method="post"  id="jp-custom-setting">
					<?php settings_fields( 'jp-settings-group-section' ); ?>
					<?php do_settings_sections( 'set-jewelry-prices' ); ?>
					<?php submit_button(); ?>
                </form>
            </div>
        </div>
    </div>
</div>