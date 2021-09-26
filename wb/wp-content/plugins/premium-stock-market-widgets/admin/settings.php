<?php defined('SMW_ROOT_DIR') or die('Direct access is not allowed'); ?>

<div id="smw-page-settings" class="bulma-column bulma-has-background-white">
  <h1 class="bulma-title bulma-is-3">
      <?php print self::NAME ?>
    <span class="bulma-tag bulma-is-primary bulma-is-large bulma-ml-2">
      <?php print self::VERSION ?>
    </span>
  </h1>
  <h2 class="bulma-subtitle bulma-is-3 bulma-has-text-grey">
    <?php esc_html_e('Settings', 'premium-stock-market-widgets') ?>
  </h2>

  <hr />

  <?php if ($settingsSaved): ?>
    <div class="bulma-content bulma-notification bulma-is-success">
      <p>
        <?php esc_html_e('Settings are successfully saved.', 'premium-stock-market-widgets') ?>
      </p>
    </div>
  <?php endif; ?>

  <div class="bulma-tabs bulma-is-boxed bulma-is-medium">
    <ul>
      <?php foreach($tabs as $id => $name): ?>
      <li class="<?php print $tab == $id ? 'bulma-is-active' : '' ?>">
        <a href="?page=premium-stock-market-widgets-settings&tab=<?php print $id ?>">
          <?php print $name ?>
        </a>
      </li>
      <?php endforeach ?>
    </ul>
  </div>

  <form method="post" action="<?php print $_SERVER['REQUEST_URI'] ?>" enctype="multipart/form-data">
    <div class="bulma-column bulma-is-4-desktop">

        <?php if ($tab == 'general'): ?>
        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Enqueue priority', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-control">
            <input type="number" name="enqueue_priority" value="<?php print $this->getConfigVariable('enqueue_priority')?>" class="bulma-input" placeholder="10">
          </div>
        </div>

        <div class="bulma-field">
          <label class="bulma-label">
              <?php esc_html_e('AJAX method', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-control">
            <div class="bulma-select">
              <select name="ajax_method">
                <option value="get" <?php print $this->getConfigVariable('ajax_method')=='get' ? 'selected="selected"' : ''?>><?php esc_html_e('GET', 'premium-stock-market-widgets') ?></option>
                <option value="post" <?php print $this->getConfigVariable('ajax_method')=='post' ? 'selected="selected"' : ''?>><?php esc_html_e('POST', 'premium-stock-market-widgets') ?></option>
              </select>
            </div>
          </div>
        </div>
      <?php endif ?>

      <?php if ($tab == 'format'): ?>
        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Thousands separator', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-control">
            <input type="text" name="thousands_separator" value="<?php print $this->getConfigVariable('thousands_separator')?>" class="bulma-input" placeholder=",">
          </div>
        </div>

        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Decimal separator', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-control">
            <input type="text" name="decimal_separator" value="<?php print $this->getConfigVariable('decimal_separator')?>" class="bulma-input" placeholder=".">
          </div>
        </div>

        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Default number format', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-control">
            <input type="text" name="default_number_format" value="<?php print $this->getConfigVariable('default_number_format')?>" class="bulma-input" placeholder="0,0.00">
            <p class="bulma-mt-1">
              <a href="http://numeraljs.com/#format" target="_blank">
                <?php esc_html_e('View supported formats', 'premium-stock-market-widgets')?>
              </a>
            </p>
          </div>
        </div>

        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Fields number format', 'premium-stock-market-widgets') ?>
          </label>
          <div class="bulma-control">
            <textarea name="fields_number_format" class="bulma-textarea"><?php print \PremiumStockMarketWidgets\WPHelper::arrayToTextarea($this->getConfigVariable('fields_number_format')) ?></textarea>
            <p class="bulma-mt-1">
              <?php esc_html_e('You can override the default number format and specify individual number format for certain fields.', 'premium-stock-market-widgets') ?>
            </p>
          </div>
        </div>

        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Display empty / null values as', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-control">
            <input type="text" name="null_value_format" value="<?php print $this->getConfigVariable('null_value_format')?>" class="bulma-input" placeholder="-">
          </div>
        </div>

        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Date locale', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-control">
            <input type="text" name="locale" value="<?php print $this->getConfigVariable('locale')?>" class="bulma-input" placeholder="en">
            <p class="bulma-mt-1">
              <a href="https://stackoverflow.com/a/55827203" target="_blank">
                <?php esc_html_e('View supported locales', 'premium-stock-market-widgets')?>
              </a>
            </p>
          </div>
        </div>

        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Default date format', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-control">
            <input type="text" name="default_date_format" value="<?php print $this->getConfigVariable('default_date_format')?>" class="bulma-input" placeholder="LL">
            <p class="bulma-mt-1">
              <a href="https://momentjs.com/docs/#/displaying/" target="_blank">
                <?php esc_html_e('View supported formats', 'premium-stock-market-widgets')?>
              </a>
            </p>
          </div>
        </div>

        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Fields date format', 'premium-stock-market-widgets') ?>
          </label>
          <div class="bulma-control">
            <textarea name="fields_date_format" class="bulma-textarea"><?php print \PremiumStockMarketWidgets\WPHelper::arrayToTextarea($this->getConfigVariable('fields_date_format')) ?></textarea>
            <p class="bulma-mt-1">
              <?php esc_html_e('You can override the default date format and specify individual date format for certain fields.', 'premium-stock-market-widgets') ?>
            </p>
          </div>
        </div>

        <div class="bulma-field">
          <div class="bulma-control">
            <label class="bulma-checkbox">
              <input type="checkbox" name="hide_symbol_suffix" <?php print $this->getConfigVariable('hide_symbol_suffix') ? 'checked' : '' ?>>
                <?php esc_html_e('Hide asset symbol (ticker) suffix', 'premium-stock-market-widgets')?>
            </label>
          </div>
        </div>
      <?php endif ?>

      <?php if ($tab == 'logo'): ?>
        <div>
          <label class="bulma-label">
            <?php esc_html_e('Default asset logo URL', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-field bulma-has-addons bulma-mt-0">
            <div class="bulma-control bulma-is-expanded">
              <input type="text" name="default_asset_logo_url" value="<?php print $this->getConfigVariable('default_asset_logo_url')?>" class="bulma-input" placeholder="">
              <p class="bulma-mt-1">
                <?php esc_html_e('Displayed if an individual logo image is not set for a given asset.', 'premium-stock-market-widgets') ?>
                <?php esc_html_e('Input an absolute URL or upload a custom logo.', 'premium-stock-market-widgets') ?>
              </p>
            </div>
            <div class="bulma-control bulma-file">
              <label class="bulma-file-label">
                <input id="default-logo-image-input" class="bulma-file-input" type="file" name="default_asset_logo_file">
                <span class="bulma-file-cta">
                  <span class="bulma-file-icon">
                    <i class="fa fa-upload"></i>
                  </span>
                  <span id="default-logo-image-input-label" class="bulma-file-label">
                    <?php esc_html_e('File...', 'premium-stock-market-widgets')?>
                  </span>
                </span>
              </label>
            </div>
            <div class="bulma-control">
              <?php if ($this->getConfigVariable('default_asset_logo_url')): ?>
                <a href="<?php print $this->getConfigVariable('default_asset_logo_url') ?>" class="bulma-button bulma-is-primary bulma-is-outlined" target="_blank">
                  <i class="fa fa-external-link-alt"></i>
                </a>
              <?php endif ?>
            </div>
          </div>
        </div>
        <div class="bulma-mt-3">
          <label class="bulma-label">
            <?php esc_html_e('Available asset logo images', 'premium-stock-market-widgets')?>
          </label>
          <div id="smw-logo-images-list">
            <?php foreach ($assetLogoImages as $symbol => $image): ?>
              <div class="smw-flexbox smw-flexbox-align-items-center">
                <figure class="bulma-image bulma-is-32x32 bulma-mr-3">
                  <img src="<?php print $image ?>">
                </figure>
                <div>
                  <?php print $symbol ?>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>
        <div class="bulma-mt-3">
          <label class="bulma-label">
            <?php esc_html_e('Upload asset logo', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-field bulma-has-addons bulma-mt-0">
            <div class="bulma-control bulma-is-expanded">
              <input type="text" name="asset_logo_symbol" value="" class="bulma-input" placeholder="<?php esc_html_e('Symbol, e.g. AAPL, MSFT etc', 'premium-stock-market-widgets') ?>">
            </div>
            <div class="bulma-control bulma-file">
              <label class="bulma-file-label">
                <input id="logo-image-input" class="bulma-file-input" type="file" name="asset_logo_file">
                <span class="bulma-file-cta">
                  <span class="bulma-file-icon">
                    <i class="fa fa-upload"></i>
                  </span>
                  <span id="logo-image-input-label" class="bulma-file-label">
                    <?php esc_html_e('File...', 'premium-stock-market-widgets')?>
                  </span>
                </span>
              </label>
            </div>
          </div>
        </div>
        <script>
          var onChange = function(event) {
            if (event.target.files.length > 0) {
              document.getElementById(event.target.id + '-label').innerText = event.target.files[0].name;
            }
          }

          document.getElementById('default-logo-image-input').onchange = onChange;
          document.getElementById('logo-image-input').onchange = onChange;
        </script>
      <?php endif ?>

      <?php if ($tab == 'integration'): ?>
        <div class="bulma-field">
          <label class="bulma-label">
              <?php esc_html_e('Google Maps API key', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-control">
            <input type="text" name="google_maps_api_key" value="<?php print $this->getConfigVariable('google_maps_api_key')?>" class="bulma-input" placeholder="">
            <p class="bulma-mt-1">
              <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank" rel="nofollow">
                <?php esc_html_e('How to get an API key?', 'premium-stock-market-widgets')?>
              </a>
            </p>
            <p>
              <?php esc_html_e('Also please ensure that Geocoding API is enabled.', 'premium-stock-market-widgets')?>
            </p>
          </div>
        </div>
      <?php endif ?>

      <?php if ($tab == 'advanced'): ?>
        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Asset names overrides', 'premium-stock-market-widgets') ?>
          </label>
          <div class="bulma-control">
            <textarea name="asset_names_overrides" class="bulma-textarea"><?php print \PremiumStockMarketWidgets\WPHelper::arrayToTextarea($this->getConfigVariable('asset_names_overrides')) ?></textarea>
            <p class="bulma-mt-1">
              <?php esc_html_e('Provide asset names overrides as SYMBOL=NAME pairs (one pair per line).', 'premium-stock-market-widgets') ?>
            </p>
          </div>
        </div>

        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Asset recognition regex', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-control">
            <input type="text" name="asset_recognition_regexp" value="<?php print $this->getConfigVariable('asset_recognition_regexp')?>" class="bulma-input" placeholder="^stock-page-([a-zA-Z0-9-\.=\^\$]+)/?$">
            <p class="bulma-mt-1">
              <a href="?page=premium-stock-market-widgets-help">
                <?php esc_html_e('Learn more about this feature', 'premium-stock-market-widgets')?>
              </a>
            </p>
          </div>
        </div>

        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Virtual asset page regex', 'premium-stock-market-widgets')?>
          </label>
          <div class="bulma-control">
            <input type="text" name="asset_page_regexp" value="<?php print $this->getConfigVariable('asset_page_regexp')?>" class="bulma-input" placeholder="^nasdaq/([a-zA-Z0-9-\.=\^\$]+)/?$">
            <p class="bulma-mt-1">
              <a href="?page=premium-stock-market-widgets-help">
                <?php esc_html_e('Learn more about this feature', 'premium-stock-market-widgets')?>
              </a>
            </p>
          </div>
        </div>

        <div class="bulma-field">
          <label class="bulma-label">
            <?php esc_html_e('Virtual asset page content', 'premium-stock-market-widgets')?>
          </label>
          <div>
            <?php wp_editor($this->getConfigVariable('asset_page_content'), self::CODE . '-asset-page-content', ['textarea_name' => 'asset_page_content']); ?>
          </div>
        </div>
      <?php endif ?>

      <div class="bulma-field bulma-mt-5">
        <div class="bulma-control">
          <button type="submit" class="bulma-button bulma-is-primary">
            <?php esc_html_e('Save', 'premium-stock-market-widgets')?>
          </button>
        </div>
      </div>
    </div>
  </form>
</div>

