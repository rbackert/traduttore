<?php
/**
 * GitLab repository implementation
 *
 * @since 3.0.0
 */

namespace Required\Traduttore\Repository;

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
	 * @return string Repository branch.
	 */
	public function get_branch(): string {
		$branch = null;
		$url    = $this->project->get_source_url_template();

		if ( $url ) {
			$path   = trim( wp_parse_url( $url, PHP_URL_PATH ), '/' );
			$path   = substr( $path, \strlen( $this->get_name() ) );
			$parts  = explode( '/', $path );
			$branch = $parts[2] ?? '';
		}

		return $branch;
	}
}
