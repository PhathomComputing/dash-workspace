<?php defined('SMW_ROOT_DIR') or die('Direct access is not allowed'); ?>

<div class="bulma-column bulma-has-background-white">
  <h1 class="bulma-title bulma-is-3">
      <?php print self::NAME ?>
    <span class="bulma-tag bulma-is-primary bulma-is-large bulma-ml-2">
      <?php print self::VERSION ?>
    </span>
  </h1>
  <h2 class="bulma-subtitle bulma-is-3 bulma-has-text-grey">
      <?php esc_html_e('Widget Builder', 'premium-stock-market-widgets') ?>
  </h2>

  <hr />

  <div id="smw-widget-builder">
    <stock-market-widget-builder></stock-market-widget-builder>
  </div>
</div>
