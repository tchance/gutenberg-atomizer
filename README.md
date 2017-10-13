# Gutenberg Atomizer for WP-API

Leveraging the block parser from Gutenberg to return a block-by-block readout of an article drafted and published via WordPress's new Gutenberg editor.

## Installation

This can be installed directly into your plugins folder "as-is". 

## Dependencies

### WP REST API

This plugins appends the atomized Gutenberg block list to the post response inside of the REST API. Make sure you have it installed.

* [WP REST API](https://wordpress.org/plugins/rest-api/)

### Gutenberg

Currently Gutenberg is in active development, not production ready and has been undergoing rapid changes. However, all this plugin does is use the parser that Gutenberg contains on its own, but it should be installed prior to installing this plugin

* [Gutenberg Plugin](https://wordpress.org/plugins/gutenberg/)

