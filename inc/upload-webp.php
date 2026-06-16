<?php

if ( ! function_exists( 'wataco_server_supports_webp_encoding' ) ) {
	/**
	 * Check whether the current server can encode WebP images.
	 *
	 * @return bool
	 */
	function wataco_server_supports_webp_encoding() {
		// GD check: imagewebp must exist and report WebP support.
		if ( function_exists( 'imagewebp' ) && function_exists( 'gd_info' ) ) {
			$gd_info = gd_info();
			if ( ! empty( $gd_info['WebP Support'] ) ) {
				return true;
			}
		}

		// Imagick check: WEBP must be in supported output formats.
		if ( extension_loaded( 'imagick' ) && class_exists( 'Imagick' ) ) {
			try {
				$formats = \Imagick::queryFormats( 'WEBP' );
				if ( ! empty( $formats ) ) {
					return true;
				}
			} catch ( Exception $e ) {
				// Silent fail-safe: keep original upload flow.
			}
		}

		return false;
	}
}

if ( ! function_exists( 'wataco_convert_upload_to_webp' ) ) {
	/**
	 * Convert uploaded JPEG/PNG files to WebP before Media Library registration.
	 *
	 * @param array $upload Upload data (file, url, type).
	 * @return array
	 */
	function wataco_convert_upload_to_webp( $upload ) {
		// Ensure we have the minimum upload payload.
		if ( empty( $upload['file'] ) || empty( $upload['url'] ) || empty( $upload['type'] ) ) {
			return $upload;
		}

		$allowed_types = array( 'image/jpeg', 'image/png' );
		$mime_type     = strtolower( (string) $upload['type'] );

		// Process only JPEG and PNG uploads; ignore all other MIME types.
		if ( ! in_array( $mime_type, $allowed_types, true ) ) {
			return $upload;
		}

		// Fail-safe: if WebP encoding is not supported, keep original file.
		if ( ! wataco_server_supports_webp_encoding() ) {
			return $upload;
		}

		$original_path = $upload['file'];
		$path_info     = pathinfo( $original_path );

		// Guard: if extension is already webp, do nothing.
		if ( isset( $path_info['extension'] ) && 'webp' === strtolower( $path_info['extension'] ) ) {
			return $upload;
		}

		$webp_path = trailingslashit( $path_info['dirname'] ) . $path_info['filename'] . '.webp';
		$editor    = wp_get_image_editor( $original_path );

		// Fail-safe: image editor unavailable or failed to load.
		if ( is_wp_error( $editor ) ) {
			return $upload;
		}

		// Attempt WebP conversion using WordPress core image editor.
		$saved = $editor->save( $webp_path, 'image/webp' );

		// Fail-safe: conversion failed, so keep original upload untouched.
		if ( is_wp_error( $saved ) || empty( $saved['path'] ) || ! file_exists( $saved['path'] ) ) {
			return $upload;
		}

		// Remove the original JPG/PNG after successful WebP creation.
		if ( file_exists( $original_path ) ) {
			@unlink( $original_path );
		}

		// Rewrite upload payload so WordPress stores the WebP in Media Library.
		$upload['file'] = $saved['path'];
		$upload['type'] = 'image/webp';
		$upload['url']  = str_replace( wp_basename( $original_path ), wp_basename( $saved['path'] ), $upload['url'] );

		return $upload;
	}
}

// Priority 1 ensures conversion runs before typical offload hooks (e.g., Media Cloud sync to R2).
add_filter( 'wp_handle_upload', 'wataco_convert_upload_to_webp', 1 );
