<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Download an image from a URL and save it locally
 * @param string $url Image URL
 * @param string $save_path Local save path
 * @return string Local image path or placeholder if download fails
 */
function download_image($url, $save_path) {
    $image_data = @file_get_contents($url); // Fetch the image
    if ($image_data !== false) {
        file_put_contents($save_path, $image_data); // Save to local file
        return $save_path; // Return the local file path
    }
    return base_url('assets/images/placeholder.jpg'); // Return placeholder if download fails
}
