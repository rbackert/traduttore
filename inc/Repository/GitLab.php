<?php
/**
 * GitLab repository implementation
 *
 * @since 3.0.0
 */

namespace Required\Traduttore\Repository;

use Required\Traduttore\GitUrl;
use Required\Traduttore\Repository;

/**
 * GitLab repository class.
 *
 * @since 3.0.0
 */
class GitLab extends Base {
	/**
	 * GitLab API base URL.
	 *
	 * @since 3.0.0
	 */
	public const API_BASE = 'https://gitlab.com/api/v4';

	/**
	 * Returns the repository type.
	 *
	 * @since 3.0.0
	 *
	 * @return string Repository type.
	 */
	public function get_type(): string {
		return Repository::TYPE_GITLAB;
	}

	/**
	 * Returns the repository host name.
	 *
	 * @since 3.0.0
	 *
	 * @return string Repository host name.
	 */
	public function get_host(): string {
		$host = parent::get_host();

		if ( $host ) {
			return $host;
		}

		return 'gitlab.com';
	}

	/**
	 * Indicates whether a GitLab repository is publicly accessible or not.
	 *
	 * @since 3.0.0
	 *
	 * @return bool Whether the repository is publicly accessible.
	 */
	public function is_public(): bool {
		$visibility = $this->project->get_repository_visibility();

		if ( ! $visibility ) {
			$response = wp_remote_head( self::API_BASE . '/projects/' . rawurlencode( $this->get_name() ) );

			$visibility = 200 === wp_remote_retrieve_response_code( $response ) ? 'public' : 'private';

			$this->project->set_repository_visibility( $visibility );
		}

		return parent::is_public();
	}

	/**
	 * Returns the repository branch.
	 *
	 * @since 3.1.0
	 *
	 * @return string Repository branch.
	 */
	public function get_branch(): string {
		$parsed = $this->parse_source_url_template();
		return $parsed->ref ?? null;
	}

	/**
	 * Parse a GlotPress source url into parts.
	 *
	 * @since 3.1.0
	 *
	 * @return \Required\Tradutore\GitUrl
	 */
	public function parse_source_url_template(): GitUrl {
		$parsed = new GitUrl();
		$url    = $this->project->get_source_url_template();

		if ( $url ) {
			$path  = trim( wp_parse_url( $url, PHP_URL_PATH ), '/' );
			$parts = explode( '/', $path );

			$parsed->owner     = $parts[0];
			$parsed->name      = $parts[1];
			$parsed->full_name = implode( '/', array_splice( $parts, 0, 2 ) );

			array_splice( $parts, 0, 2 );

			$parsed->branch = array_shift( $parts );

			array_pop( $parts );

			$parsed->filepath = implode( '/', $parts );
		}

		return $parsed;
	}
}
