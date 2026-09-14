let mix = require('laravel-mix');
let rtlcss = require('rtlcss'); /* rtlcss with laravel mix => https://github.com/MohammadYounes/rtlcss/issues/96 */

// Compile JavaScript and Extract All Vendor Dependencies => .extract();
// Make jQuery Available to Every Module => .autoload({jquery: ['$', 'window.jQuery']});
// .setPublicPath('assets')
mix.disableSuccessNotifications()
   .extract()
   .js('wp-content/themes/givenntheme/src/app.js', 'wp-content/themes/givenntheme/assets/js')
   .sass('wp-content/themes/givenntheme/src/main.scss', 'wp-content/themes/givenntheme/style.css').options({
      processCssUrls: false
   })
   .sass("wp-content/themes/givenntheme/src/main-rtl.scss", "wp-content/themes/givenntheme/style-rtl.css", {}, [
      require("rtlcss")(),
   ])
   .sourceMaps();