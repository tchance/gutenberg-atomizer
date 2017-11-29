<?

/*
Plugin Name: Gutenberg Atomizer
Plugin URI: http://tylerchance.net
Description: Returns an atomized version of Gutenberg articles in the WP-REST API. 
Version: 0.0.2
Author: Tyler Chance
Author URI: http://tylerchance.net
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

//  Fire add_post_source on rest_api_init
add_action( 'rest_api_init', 'add_post_source' );

//  Add gutenberg_atoms field into the rest api response for a post
//  call to get_post_src
function add_post_source() {
    register_rest_field( 'post',
        'gutenberg_atoms', 
        array(
            'get_callback'    => 'get_post_src',
            'update_callback' => null,
            'schema'          => null,
            )
        );
}

//  retrieves post by id, then sends into the parser
function get_post_src( $object, $field_name, $request ) {
    $the_post = get_post($object['id'], true);
    return turn_into_array($the_post['post_content']); 
}


/*
    Gutenberg parser response per block (It checks for the blockName component in order to drop blocks that are blank,
    which Gutenberg tends to use to represent spaces between paragraphs): 
        {
            type: blockName,
            attributes: attrs,
            content: rawContent
        }
    WP-API returns PHP Array as an array of JSON Objects
*/
function turn_into_array($html) {
    if (class_exists('Gutenberg_PEG_Parser')) {
        $gutenberg_response = array();
        $parser = new Gutenberg_PEG_Parser();
        $parsed_blocks = $parser->parse($html);
        foreach ($parsed_blocks as $block) {
            if ($block['blockName']) {
                $this_block = array(
                    'type' => $block['blockName'],
                    'attributes' => $block['attrs'],
                    'content' => $block['innerHTML']
                );
                array_push($gutenberg_response, $this_block);
            }
        }
        return $gutenberg_response;
    }
}

