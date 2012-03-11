=== Slyd ===
Contributors: paraplegicpanda
Donate link: http://trezy.com/slyd
Tags: slyd, slydr, slide, slider, wordpress, plugins, carousel, banners, featured content, gallery, image rotation, javascript slider, jquery slider, responsive, slideshow
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: 1.3.2

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

* `category` - Add the category(s) you want Slyd to be limited to. Separate multiple categories with commas. Default is all categories.
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
* `use_featured` - By default Slyd will load a post's Featured Image if there is no Slyd Image. Setting this to `false` disable the use of Featured Images in Slyd.
* `no_links` - Setting this to `true` will cause Slyd to not link slyds to their posts. Default is `false`.

**Usage**

`[slyd category='foo' slydcount='3', nav='show' height='300' width='960px' outline='orange' show_titles='false' show_captions='false' caption_length='200' speed='3000' autoadvance='false' use_featured='false' no_links=`true`]`

= How can I customize my Slyd template tag? =

The Slyd template tag supports the same options as the shortcode. Enter the category as an empty value to get all categories, i.e. `<?php slyd( '', 3,` ... `, true ?>`

**Usage**

`<?php slyd( $category, $slydcount, $nav, $height, $width, $outline, $show_titles, $show_captions, $caption_length, $autoadvance, $speed, $use_featured, $no_links ); ?>`

`<?php slyd( 'foo', '3', 'show', '300', '960px', 'orange', false, false, 200, false, 3000, false, true ); ?>`

= I need more help! =

If you just can't figure out how to use Slyd, shoot me an email! I'm happy to help and thus further my name in preparation for world domina... I mean, I offer customer support.

Email: tre [at] trezy [dot] com

Website: http://trezy.com

== Upgrade Notice ==

No major changes needed, just upgrade from the Wordpress interface. ;-)

== Plans for the Future ==
* **Themes**
* **Custom Slyd caption for each post**
* **Image Options** - Fit (image stretches to fitwidth of container) or Center (image maintains original proportions ans can anchor to the center, any corner, or any side).
* **Animation Options** - Slide, Slide Over, or Fade
* **Option to remove Slyd Image from a post**

== Changelog ==

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