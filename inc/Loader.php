<?php
/**
 * Source code loader interface
 *
 * @since 3.0.0
 */

namespace Required\Traduttore;

/**
 * Loader interface.
 *
 * @since 3.0.0
 */
interface Loader {
	/**
	 * Class constructor.
	 *
	 * @since 3.0.0
	 *
	 * @param \Required\Traduttore\Repository $repository Repository instance.
	 */
	public function __construct( Repository $repository );

	/**
	 * Downloads a remote repository.
	 *
	 * If the repository has been downloaded before, the latest changes will be pulled.
	 *
	 * @since 3.0.0
	 *
	 * @return string Path to the downloaded repository on success.
	 */
	public function download(): ?string;

	/**
	 * Returns the local repository path.
	 *
	 * @since 3.0.0
	 *
	 * @return string Repository path.
	 */
	public function get_local_path(): string;

	/**
	 * Returns the local project path (for monorepos).
	 *
	 * @since 3.1.0
	 *
	 * @return string Project path.
	 */
	public function get_project_path(): string;
}
