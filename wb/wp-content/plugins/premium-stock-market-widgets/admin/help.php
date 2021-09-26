<?php defined('SMW_ROOT_DIR') or die('Direct access is not allowed'); ?>

<div class="bulma-column bulma-has-background-white">
  <h1 class="bulma-title bulma-is-3">
    <?php print self::NAME ?>
    <span class="bulma-tag bulma-is-primary bulma-is-large bulma-ml-2">
      <?php print self::VERSION ?>
    </span>
  </h1>
  <h2 class="bulma-subtitle bulma-is-3 bulma-has-text-grey">
    <?php esc_html_e('Help', 'premium-stock-market-widgets') ?>
  </h2>

  <hr />

  <div class="bulma-block">
    <h3 class="bulma-subtitle bulma-is-4">
      Usage in pages or posts
    </h3>
    <div class="bulma-content">
      <p>
        To add a widget to a page or post please do the following:
      </p>
      <ol>
        <li>Open <a href="?page=premium-stock-market-widgets-builder">Widget Builder</a></li>
        <li>Choose a widget you need and customize its settings</li>
        <li>Copy the widget shortcode to clipboard</li>
        <li>Paste the shortcode to a page or post</li>
      </ol>
    </div>
  </div>

  <div class="bulma-block">
    <h3 class="bulma-subtitle bulma-is-4">
      Usage in WordPress widget areas
    </h3>
    <div class="bulma-content">
      <p>
        If you like to add a widget to one of the <a href="widgets.php">WordPress widgets areas</a> you have to install
        an extra WordPress plugin (<a href="https://wordpress.org/plugins/shortcode-widget/" target="_blank">this one</a> or similar),
        which enables usage of shortcodes in widgets.
        After the plugin is installed and enabled complete the steps described in the above section
        and then paste the generated widget shortcode to a widget area.
      </p>
    </div>
  </div>

  <div class="bulma-block">
    <h3 class="bulma-subtitle bulma-is-4">
      Usage in WordPress templates
    </h3>
    <div class="bulma-content">
      <p>
        If you like to insert a widget directly into a WordPress template you need to generate the shortcode and wrap it in a <i>do_shortcode()</i> function call like this:
      </p>
      <pre>&lt;?php echo do_shortcode('[stock_market_widget type="card" template="basic" color="#0070ff" assets="AAPL" api="yf"]');?&gt;</pre>
      <p>
        If you use a page builder it should be even easier. For instance, if you use Elementor you can install
        <a href="https://wordpress.org/plugins/header-footer-elementor/" target="_blank">Header, Footer & Blocks Template</a> plugin, create a custom header or footer template
        and add necessary widgets there.
      </p>
    </div>
  </div>

  <div class="bulma-block">
    <h3 class="bulma-subtitle bulma-is-4">
      How to translate the plugin?
    </h3>
    <div class="bulma-content">
      <p>
        You can translate all static text strings into any language (or override the default English text strings) by
        using a WPML compatible plugin, such as <a href="https://wordpress.org/plugins/loco-translate/" target="_blank">Loco Translate</a>.
      </p>
    </div>
  </div>

  <div class="bulma-block">
    <h3 class="bulma-subtitle bulma-is-4">
      Auto asset recognition
    </h3>
    <div class="bulma-content">
      <p>
        When a website contains many similarly structured pages (where each page provides information about
        a particular asset), it can be useful that asset symbol is automatically obtained from the page URL rather than each individual widget shortcode.
        This way you can have exactly the same shortcodes across all such pages (probably auto generated), but the plugin will automatically
        capture the asset symbol from the page URL and display corresponding market data.
        To set this up you need to specify <b>Asset recognition regex</b>, which should be a valid regular
        expression with a group to capture the asset symbol from the URL.
      </p>
      <p>
        Let's consider an example. Suppose you have 3 pages with the following URLs:
        https://yourwebsite.com/stock-page-aapl,
        https://yourwebsite.com/stock-page-goog,
        https://yourwebsite.com/stock-page-fb.
        In this case you can specify the following regular expression in the <b>Asset recognition regex</b> setting:
      <pre><code>^stock-page-([a-zA-Z0-9-\.=\^\$]+)/?$</code></pre>
      <p>
        When either of the above pages is accessed the plugin will capture the asset symbol (AAPL, GOOG or FB respectively) from the URL and display corresponding market data,
        irrespective of what symbol is specified in the <b>assets</b> parameter of the widget shortcode.
      </p>
      <p>
        Please note, that on such pages all multi-asset widgets (such as accordion, table, portfolio etc) will also be overridden and use
        the asset symbol provided in the URL.
      </p>
    </div>
  </div>

  <div class="bulma-block">
    <h3 class="bulma-subtitle bulma-is-4">
      Virtual asset pages
    </h3>
    <div class="bulma-content">
      <p>
        When you like to have a dedicated page for every asset (e.g. stock) from a specific market it can be cumbersome
        to manually create a lot of pages. In this case you can have the plugin to auto generate and display such pages automatically on demand.
        You need to specify a regular expression in the <b>Virtual asset page regex</b> setting.
        When a visitor requests a page, which URL matches this expression, a virtual asset page will be automatically created and displayed to the visitor.
        The content of such pages will be generated based on the <b>Virtual asset page content</b> setting. There you can
        insert any number of stock widgets (as well as some static content - text, images etc)
        and the plugin will automatically capture the necessary asset symbol from the URL and display the corresponding market data.
      </p>
      <p>
        Suppose that you want the plugin to auto generate a virtual asset page when the following URLs are requested:
        https://yourwebsite.com/nasdaq/aapl, https://yourwebsite.com/nasdaq/msft, https://yourwebsite.com/nasdaq/goog etc.
        In this case you can specify the following regular expression in the <b>Virtual asset page regex</b> setting:
      </p>
      <pre><code>^nasdaq/([a-zA-Z0-9-\.=\^\$]+)/?$</code></pre>
      <p>
      You can then insert the following widget shortcode (as an example) to the <b>Virtual asset page content</b>:
      </p>
      <pre><code>[stock_market_widget type="card" template="basic3" color="#0070ff" assets="AAPL" api="yf"]</code></pre>
      <p>
      After that, when user opens this page, for instance: https://yourwebsite.com/nasdaq/aapl, the plugin will display an auto-generated page with Apple Inc. widget on it
      (in this case it doesn't matter which asset is specified in the widget shortcode). Of course, you can add as many widgets to auto generated pages as you like.
      </p>
      <p>
        Please note, that on virtual asset pages all multi-asset widgets (such as accordion, table, portfolio etc)
        will NOT inherit the asset symbols from the URL, but will use those from the shortcode.
      </p>
      <p>
        The main difference between <b>Auto coin recognition</b> and <b>Virtual coin pages</b> features is that the former is suitable
        for <b>existing</b> pages or posts and the latter is used to handle requests to <b>non-existing</b> (virtual) pages.
      </p>
    </div>
  </div>

  <div class="bulma-block">
    <h3 class="bulma-subtitle bulma-is-4">
      How to override the number / date format for a particular widget?
    </h3>
    <div class="bulma-content">
      <p>
        Sometimes you might want to format a value in some widget differently than it's specified in the global format settings.
        Let's say, you would like to display the price and absolute change in a specific widget with 4 decimals.
        In this case you need to manually add <b>format</b> property to the widget shortcode. The value of the format property
        should contain FIELD=FORMAT pairs separated by the pipe ("|") symbol. Here is an example:
      </p>
      <pre>[stock_market_widget type="card" template="basic" color="#0070ff" assets="EURUSD=X" <b>format="price=0,0.0000|change_abs=0,0.0000"</b> api="yf"]</pre>
      <p>
        In this case the format specified in the widget shortcode will take precedense over the global format settings.
      </p>
    </div>
  </div>

  <div class="bulma-block">
    <h3 class="bulma-subtitle bulma-is-4">
      Why there are no logo images for many companies?
    </h3>
    <div class="bulma-content">
      <p>
        Unfortunately there is no (free or paid) public source of company logo images around the world.
        The plugin provides logo images of some public US companies, as an example.
        If you like to add a logo image of a particular company or asset you can upload the image file by navigating to <b>Settings</b> » <b>Logo images</b>.
      </p>
    </div>
  </div>

  <div class="bulma-block">
    <h3 class="bulma-subtitle bulma-is-4">
      How to change the chart widget height?
    </h3>
    <div class="bulma-content">
      <p>
        In order to change the chart widget height you need to add the following CSS rule to your page or post (change 600px to any specific height you need):
      </p>
      <pre>.smw-root>.smw-chart-widget-container>.smw-chart {
  height: 600px !important;
}</pre>
      <p>
        Usually a CSS rule can be added by clicking <b>Customize</b> » <b>Additional CSS</b>.
      </p>
    </div>
  </div>

  <div class="bulma-block">
    <h3 class="bulma-subtitle bulma-is-4">
      How to move the plugin from a dev website to production?
    </h3>
    <div class="bulma-content">
      <p>
        Please follow the below steps:
      </p>
      <ol>
        <li>Go to <a href="plugins.php">Plugins</a> page, deactivate and uninstall the plugin from your dev website.</li>
        <li>Install and activate the plugin on your live / production website.</li>
      </ol>
      <p>
        Please note that you will not be able to install the plugin on the live website if you have not properly uninstalled it previously.
        If you like to run the plugin on both dev and production environments at the same time you need to purchase 2 licenses.
      </p>
    </div>
  </div>

  <div class="bulma-block">
    <h3 class="bulma-subtitle bulma-is-4">
      How to get support?
    </h3>
    <div class="bulma-content">
      <p>
        If you need any further help submit a new support ticket at <a href="https://support.financialplugins.com/" target="_blank">support.financialplugins.com</a>.
        Please note that you need to have a valid support period to be able to open new tickets
        (<a href="https://help.market.envato.com/hc/en-us/articles/207886473-Extending-and-Renewing-Item-Support" target="_blank">how to renew my support?</a>).
      </p>
      <p>
        <a href="https://support.financialplugins.com/" target="_blank" class="bulma-button bulma-is-primary">
          Submit a ticket
        </a>
      </p>
    </div>
</div>
