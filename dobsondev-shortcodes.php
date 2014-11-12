<?php
/**
 * Plugin Name: DobsonDev Shortcodes
 * Plugin URI: http://dobsondev.com/portfolio/dobsondev-shortcodes/
 * Description: A collection of helpful shortcodes.
 * Version: 0.673
 * Author: Alex Dobson
 * Author URI: http://dobsondev.com/
 * License: GPLv2
 *
 * Copyright 2014  Alex Dobson  (email : alex@dobsondev.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


/* Enqueue the Style Sheet */
function dobson_enqueue_scripts() {
  wp_enqueue_style( 'dobsondev-shortcodes', plugins_url( 'dobsondev-shortcodes.css' , __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'dobson_enqueue_scripts' );


/* Adds a shortcode for displaying PDF's Inline */
function dobson_embed_PDF($atts) {
  extract(shortcode_atts(array(
    'source' => "Invalid Source",
    'width' => "100%",
    'height' => "600",
  ), $atts));
  if ($source == "http://yoursite.com/path-to-the-pdf.pdf") {
    $source = "Invalid Source";
  }
  if ($width == "###" || $height == "###") {
    $width = "100%";
    $height = "600";
  }
  $source_headers = @get_headers($source);
  if (strpos($source_headers[0], '404 Not Found')) {
    return '<p> Invalid PDF source. Please check your PDF source. </p>';
  } else {
    return '<object width="' . $width . '" height="' . $height . '" type="application/pdf" data="'
    . $source . '"></object>';
  }
}
add_shortcode('embedPDF', 'dobson_embed_pdf');


/* Adds a shortcode for displaying GitHub Gists */
function dobson_create_github_gist($atts) {
  extract(shortcode_atts(array(
    'source' => "Invalid Source",
  ), $atts));
  if ($source == "http://gist.github.com/your-account/gist-id") {
    $source = "Invalid Source";
  }
  $source_headers = @get_headers($source);
  if (strpos($source_headers[0], '404 Not Found')) {
    return '<p> Invalid GitHub Gist source. Please check your source. </p>';
  } else {
    return '<script src="' . $source . '.js"></script>';
  }
}
add_shortcode('embedGist', 'dobson_create_github_gist');


/* Adds a shortcode to embed a Twitch Stream */
function dobson_embed_twitch($atts) {
  extract(shortcode_atts(array(
    'username' => "Invalid Username",
    'width' => "620",
    'height' => "378",
  ), $atts));
  if ($username == "your-username") {
    $source = "Invalid Username";
  }
  if ($width == "###" || $height == "###") {
    $width = "620";
    $height = "378";
  }
  $source_headers = @get_headers("http://twitch.tv/" . $username);
  if (strpos($source_headers[0], '404 Not Found')) {
    return '<p> Invalid Twitch channel name. Please check your username and channel settings on Twitch to make '
    . 'sure they are setup correctly. </p>';
  } else {
    return '<object type="application/x-shockwave-flash" height="' . $height . '" width="' . $width
    . '" id="live_embed_player_flash" data="http://www.twitch.tv/widgets/live_embed_player.swf?channel='
    . $username . '" bgcolor="#000000">
    <param name="allowFullScreen" value="true" />
    <param name="allowScriptAccess" value="always" />
    <param name="allowNetworking" value="all" />
    <param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" />
    <param name="flashvars" value="hostname=www.twitch.tv&channel=' . $username . '&auto_play=true&start_volume=25" />
    </object>';
  }
}
add_shortcode('embedTwitch', 'dobson_embed_twitch');


/* Adds a shortcode to embed a Twitch Stream's chat */
function dobson_embed_twitch_chat($atts) {
  extract(shortcode_atts(array(
    'username' => "Invalid Username",
    'width' => "350",
    'height' => "500",
  ), $atts));
  if ($username == "your-username") {
    $source = "Invalid Username";
  }
  if ($width == "###" || $height == "###") {
    $width = "620";
    $height = "378";
  }
  $source_headers = @get_headers("http://twitch.tv/chat/embed?channel=" . $username . "&popout_chat=true");
  if (strpos($source_headers[0], '404 Not Found')) {
    return '<p> Invalid Twitch channel name. Please check your username and channel settings on Twitch to make '
    . 'sure they are setup correctly. </p>';
  } else {
    return '<iframe frameborder="0" scrolling="no" id="chat_embed" src="http://twitch.tv/chat/embed?channel='
    . $username . '&popout_chat=true" height="' . $height . '" width="' . $width . '"></iframe>';
  }
}
add_shortcode('embedTwitchChat', 'dobson_embed_twitch_chat');


/* Adds a shortcode to embed a YouTube video */
function dobson_embed_youtube($atts) {
  extract(shortcode_atts(array(
    'video' => "Invalid Video ID",
    'width' => "560",
    'height' => "315",
  ), $atts));
  if ($video == "video-id") {
    $source = "Invalid Video ID";
  }
  if ($width == "###" || $height == "###") {
    $width = "560";
    $height = "315";
  }
  $source_headers = @get_headers("http://youtube.com/watch?v=" . $video);
  if (strpos($source_headers[0], '404 Not Found')) {
    return '<p> Invalid YouTube video ID. Please check your YouTube video ID. </p>';
  } else {
    return '<div class="dobdev_youtube_container">'
    . '<iframe width="' . $width . '" height="' . $height . '" src="//www.youtube.com/embed/' . $video
    . '" frameborder="0" allowfullscreen></iframe>'
    . '</div>';
  }
}
add_shortcode('embedYouTube', 'dobson_embed_youtube');


/* Adds a shortcode for start tags for displaying inline code */
function dobson_inline_code_start($atts) {
  extract(shortcode_atts(array(
  ), $atts));
  return '<code class="dobdev_code_inline"><strong>';
}
add_shortcode('startCode', 'dobson_inline_code_start');


/* Adds a shortcode for end tags for displaying inline code */
function dobson_inline_code_end($atts) {
  extract(shortcode_atts(array(
  ), $atts));
  return '</strong></code>';
}
add_shortcode('endCode', 'dobson_inline_code_end');


/* Adds a shortcode for the start tags for displaying a code block */
function dobson_code_block_start($atts) {
  extract(shortcode_atts(array(
  ), $atts));
  return '<pre class="dobdev_code_block"><code>';
}
add_shortcode('startCodeBlock', 'dobson_code_block_start');


/* Adds a shortcode for the end tags for displaying a code block */
function dobson_code_block_end($atts) {
  extract(shortcode_atts(array(
  ), $atts));
  return '</code></pre>';
}
add_shortcode('endCodeBlock', 'dobson_code_block_end');


/* Adds a shortcode for displaying a simple CSS only button */
function dobson_shortcode_button($atts) {
  extract(shortcode_atts(array(
    'text' => "Button",
    'color' => "red",
    'link' => "#",
  ), $atts));
  if ($color == "color") {
    $color = "red";
  }
  return '<a class="' . $color . 'DobsonDevShortcodeButton" href="' . $link . '">' . $text . '</a>';
}
add_shortcode('button', 'dobson_shortcode_button')

?>