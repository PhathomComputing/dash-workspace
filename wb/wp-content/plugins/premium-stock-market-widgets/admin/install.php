<?php defined('SMW_ROOT_DIR') or die('Direct access is not allowed'); ?>

<div class="bulma-column bulma-has-background-white">
  <h1 class="bulma-title bulma-is-3">
      <?php print self::NAME ?>
    <span class="bulma-tag bulma-is-primary bulma-is-large bulma-ml-2">
      <?php print self::VERSION ?>
    </span>
  </h1>
  <h2 class="bulma-subtitle bulma-is-3 bulma-has-text-grey">
    <?php esc_html_e('Finish installation', 'premium-stock-market-widgets') ?>
  </h2>

  <hr />

  <?php if ($success): ?>
    <div class="bulma-content bulma-notification bulma-is-success">
      <p>
        <?php esc_html_e('Installation successfully completed!', 'premium-stock-market-widgets') ?>
      </p>
    </div>
    <div>
      <a href="?page=premium-stock-market-widgets-builder" class="bulma-button bulma-is-primary">
        <?php esc_html_e('Widget Builder', 'premium-stock-market-widgets')?>
      </a>
    </div>
  <?php else: ?>
    <?php if($message): ?>
      <div class="bulma-content bulma-notification bulma-is-danger">
        <p>
          <?php print $message ?>
        </p>
      </div>
    <?php else: ?>
      <div class="bulma-content bulma-notification bulma-is-primary">
        <p>
          <?php esc_html_e('To complete installation please enter your purchase code below.', 'premium-stock-market-widgets') ?>
        </p>
      </div>
    <?php endif; ?>

    <form method="post" action="<?php print $_SERVER['REQUEST_URI'] ?>">
      <div class="bulma-column bulma-is-4-desktop">

        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Purchase code', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-control">
            <input type="text" name="purchase_code" value="<?php print isset($_POST['purchase_code']) ? $_POST['purchase_code'] : $this->purchaseCode?>" class="bulma-input">
          </div>
          <p class="bulma-mt-1">
            <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">
              <?php esc_html_e('Where is my purchase code?', 'premium-stock-market-widgets')?>
            </a>
          </p>
        </div>

        <div class="bulma-field bulma-mt-5">
          <div class="bulma-control">
            <button type="submit" class="bulma-button bulma-is-primary">
              <?php esc_html_e('Proceed', 'premium-stock-market-widgets')?>
            </button>
          </div>
        </div>
      </div>
    </form>
  <?php endif; ?>
</div>

