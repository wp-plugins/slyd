=== Slyd ===
Contributors: paraplegicpanda
Donate link: http://trezy.com/slyd
Tags: slyd, slydr, slide, slider, wordpress, plugins, carousel, banners, featured content, gallery, image rotation, javascript slider, jquery slider, responsive, slideshow
Requires at least: 3.0
Tested up to: 3.4.2
Stable tag: 1.3.5

Slyd is an animated Slydr to display your latest blog posts.

== Description ==

Slyd is an easy-to-use, highly-customizable slider plugin for WordPress. There are plenty of plugins out there that allow you to easily insert a slider into your WordPress using a shortcode but they require creating a custom slide for every post you write.

With Slyd you can shirk those inconveniences. Slyd automatically pulls in all of your latest posts (or just the ones in a certain category). All Slyd requires is that you upload a Slyd image or a Featured image on your post page.

* **CSS3/jQuery Animations** - Slyd is built to be pretty so naturally it uses CSS3 and jQuery to impress viewers.
* **Category Selection** - Create a new Category or use an existing one to limit the posts that display in the Slydr.
* **Shortcode** - Normal users can insert the `[slyd]` shortcode to display the Slydr.
* **PHP Template Tag** - For more advanced users, install Slyd into a theme using `<?php slyd(); ?>`.
* **Responsive Design** - Slyd is built to scale with it's container, allowing it to look great whether it's on a desktop, tablet, or mobile phone.

== Installation ==

1. Upload the `slyd` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Either use the shortcode `[slyd]` in the page Slydr is to display *or* place `<?php slyd(); ?>` in your templates

== Frequently Asked Questions ==

= How do I use Slyd? =

Either use the shortcode `[slyd]` in the page Slydr is to display *or* place `<?php slyd(); ?>` in your templates.

= How can I customize my Slyd shortcode? =

The Slyd shortcode supports the following options:

* `category` - Add the category(s) you want Slyd to be limited to. Default is all categories.
* `slydcount` - How many posts you want Slyd to display. Default is 5.
* `nav` - Determines how to display the navigation arrows. Options are `show` for always visible arrows, `hide` to get rid of the arrows entirely, or `hover` to only display the arrows when a user hovers over the Slydr. Defaults to `hover`.
* `height` - Set the height for your Slydr. Must be defined in pixels, but don't include the unit (i.e. `height='500'`). Defaults to the height of your tallest slyd image.
* `width` - Set the width for your Slydr. Can be defined in any unit - i.e. `%`, `px`, `em`, etc. - and must include the unit (i.e. `width='960px'`). Defaults to 100%. 
* `outline` - Set an outline for your Slydr. Can be defined as any CSS readable color (i.e. `#00f`, `#0000ff`, `rgba(0, 0, 255, 1)`, `red`) or set to `none`. Defaults to black.
* `show_titles` - Show/Hide blog titles. Can be set to either `true` or `false`. Defaults to `true`.
* `show_captions` - Same as `show_titles`, but for your blog's excerpt.
* `caption_length` - Set the length of Slyd captions in characters. Defaults to `150`.
* `speed` - Set the speed for your Slydr, i.e. how long a slyd will stay before switching to the next one. Define in milliseconds (`1000` = 1 second). Defaults to `4000` or 4 seconds.
* `autoadvance` - Set to `false` to stop autoadvance. Defaults to `true`.
* `use_featured` - Determines when Slyd should use Featured images. Options are `always` to use Featured images instead of Slyd images, `noslyd` to only use it if there is no Slyd image, or `never` to only use Slyd images. Defaults to `never`.
* `no_links` - Set this to 'true' to use Slyd as a slideshow. Defaults to 'false'.
* `custom_loading_image` - Set this to the path to your custom loading image, i.e. `http://mywebsite.com/images/custom_loader.gif`. **Disabled in this version**
* `nav_images` - Set this to the directory of your navigation images, i.e. `http://mywebsite.com/images/`. This assumes your nav images are called `next.png` and `previous.png` respectively.
* `nav_prev` - Set this to the path to your previous image, i.e. `http://mywebsite.com/images/previous.png`.
* `nav_next` - Set this to the path to your next image, i.e. `http://mywebsite.com/images/next.png`.

**NOTE:** `custom_loading_image`, `nav_images`, `nav_prev`, and `nav_next` all need an absolute path to your image. This means the path must include your domain name, i.e. `/images/previous.png` won't work, but `http://mywebsite.com/images/previous.png` will. These four options will be heavily modified in the future to make them much simpler and more extensible.

**Usage**

`[slyd category='foo' slydcount='3', nav='show' height='300' width='960px' outline='orange' show_titles='false' show_captions='false' caption_length='200' speed='3000' autoadvance='false' use_featured='false' no_links='always' custom_loading_image='mywebsite.com/loading.gif' nav_images='mywebsite/nav_images/' nav_prev='mywebsite/nav_images/previous.png' nav_next='mywebsite/nav_images/next.png']`

= How can I customize my Slyd template tag? =

The Slyd template tag supports the same options as the shortcode. Use `all` to get all categories, i.e. `<?php slyd( 'all', 3,` ... `, 'always' ?>`

**Usage**

`<?php slyd( $category, $slydcount, $nav, $height, $width, $outline, $show_titles, $show_captions, $caption_length, $autoadvance, $speed, $use_featured, $no_links, $custom_loading_image, $nav_images, $nav_prev, $nav_next ); ?>`

`<?php slyd( 'foo', '3', 'show', '300', '960px', 'orange', false, false, 200, false, 3000, false, 'always', 'mywebsite.com/loading.gif', 'mywebsite/nav_images/', 'mywebsite/nav_images/previous.png', 'mywebsite/nav_images/next.png' ); ?>`

= I need more help! =

If you just can't figure out how to use Slyd, shoot me an email! I'm happy to help and thus further my name in preparation for world domina... I mean, I offer customer support.

Email: tre [at] trezy [dot] com

Website: http://trezy.com

== Upgrade Notice ==

If you are upgrading from version 1.3.2, make sure to update your `use_featured` and `category` settings.

If you are on version 1.3.4, make sure to upgarde to 1.3.5 to get rid of the major errors that 1.3.4 caused.

Otherwise, no major changes needed. Just upgrade from the Wordpress interface. ;-)

== Plans for the Future ==
* **Themes**
* **Custom Slyd caption for posts**
* **Image Options** - Fit (image stretches to fitwidth of container) or Center (image maintains original proportions ans can anchor to the center, any corner, or any side).
* **Animation Options** - Slide, Slide Over, or Fade
* **Option to remove Slyd Image from a post**

== Changelog ==

= 1.3.5 =
* Removed preloader (functionality temporarily broken)
* Fixed captions loading even if they're not displayed
* Fixed error where Slyd caused any loops run after it to be cut off. This bug messed up several other plugins and themes. Should fix a great many problems.

= 1.3.4 =
* Added preloader
* Added option to changepreloader image
* Added option to change navigation button images

= 1.3.3 =
* Changed `use_featured` to use `always`, `never`, or `noslyd` instead of `true` or `false`.
* Changed `category` to use `all` to display all posts.
* Fixed an issue causing all following posts to be hidden if one post didn't have an image.
* Fixed fade animation for nav arrows.
* Updated nav arrows to use CSS3 fade effects instead of jQuery.

= 1.3.2 =
* Removed some debugging code that was left in by accident.

= 1.3.1 =
* Template tag should now work with an empty category attribute.

= 1.3.0 =
* Added `use_featured` attribute.
* Added `caption_length` attribute.
* Added `no_links` attribute.
* If a post has neither a Slyd or a Featured image, Slyd will hide the post and load one more.

= 1.2.3 =
* Fixed a bug causing the height parameter to only work if "value > tallest image height".

= 1.2.2 =
* More minor bug fixes.

= 1.2.1 =
* Fixed a bug causing the nav arrows to not display.
* Fixed a major issue with the way Slyd retrieves the Slyd Image from each post.

= 1.2 =
* Added `nav` to change when the navigation arrows display.

= 1.1 =
* Slydrs now auto advance by default, `autoadvance` attribute can change this and `speed` attribute can adjust the speed. Hovering over the Slydr pauses the auto advance.
* Now using jQuery.doTimeout by Ben Alman.
* Cleaned up some of the PHP.
* Added more comments to both PHP and Javascript.
* Minor bug fixes.

= 1.0 =
* Launch.