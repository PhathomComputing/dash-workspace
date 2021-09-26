<?php defined('SMW_ROOT_DIR') or die('Direct access is not allowed'); ?>

<div class="bulma-column bulma-has-background-white">
  <h1 class="bulma-title bulma-is-3">
      <?php print self::NAME ?>
    <span class="bulma-tag bulma-is-primary bulma-is-large bulma-ml-2">
      <?php print self::VERSION ?>
    </span>
  </h1>
  <h2 class="bulma-subtitle bulma-is-3 bulma-has-text-grey">
    <?php esc_html_e('Add-ons', 'premium-stock-market-widgets') ?>
  </h2>

  <hr />

  <?php if ($post): ?>
    <?php if ($installed): ?>
      <div class="bulma-content bulma-notification bulma-is-success">
        <p>
          <?php esc_html_e('Installation successfully completed!', 'premium-stock-market-widgets') ?>
        </p>
      </div>
    <?php else: ?>
      <div class="bulma-content bulma-notification bulma-is-danger">
        <p>
          <?php print $message ?>
        </p>
      </div>
    <?php endif; ?>
  <?php endif; ?>

  <?php foreach ($this->addons as $id => $addon): ?>
    <div class="bulma-column bulma-is-half-desktop bulma-is-one-third-widescreen">
      <div class="bulma-card">
        <header class="bulma-card-header">
          <p class="bulma-card-header-title bulma-is-size-5">
            <?php print $addon->name ?>
          </p>
        </header>
        <div class="bulma-card-content">
          <div class="bulma-content">
            <?php print $addon->description ?>
          </div>
          <form method="post" action="<?php print $_SERVER['REQUEST_URI'] ?>">
            <input type="hidden" name="addon_id" value="<?php print $id ?>">
            <div class="bulma-field">
              <label class="bulma-label">
                <?php esc_html_e('Purchase code', 'premium-stock-market-widgets')?>
              </label>
              <div class="bulma-control">
                <input type="text" name="purchase_code" value="<?php print get_option("smw_{$id}_purchase_code") ?>" placeholder="<?php esc_html_e('Purchase code', 'premium-stock-market-widgets')?>" class="bulma-input" required>
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
                  <?php esc_html_e($addon->installed ? 'Update add-on' : 'Install add-on', 'premium-stock-market-widgets')?>
                </button>
              </div>
            </div>
          </form>
        </div>
        <footer class="bulma-card-footer">
          <?php if($addon->installed): ?>
            <div class="bulma-card-footer-item">
              <i class="fa fa-check bulma-mr-2 bulma-has-text-success"></i>
              <span><?php esc_html_e('Installed', 'premium-stock-market-widgets') ?></span>
            </div>
          <?php else: ?>
            <a href="https://stockmarketwidgets.financialplugins.com" class="bulma-card-footer-item" target="_blank">
              <i class="fa fa-external-link-alt bulma-mr-2"></i>
              <?php esc_html_e('Demo', 'premium-stock-market-widgets') ?>
            </a>
            <a href="<?php print $addon->purchase_url ?>" class="bulma-card-footer-item" target="_blank">
              <i class="fa fa-shopping-cart bulma-mr-2"></i>
              <?php esc_html_e('Purchase', 'premium-stock-market-widgets') ?>
            </a>
          <?php endif; ?>
        </footer>
      </div>
    </div>
  <?php endforeach; ?>
</div>

