<?php
/**
 * Base source code loader implementation
 */

namespace Required\Traduttore\Loader;

use Required\Traduttore\Loader;
use Required\Traduttore\Repository;

/**
 * Base loader.
 *
 * @since 3.0.0
 */
abstract class Base implements Loader {
	/**
	 * Repository information.
	 *
	 * @since 3.0.0
	 *
	 * @var \Required\Traduttore\Repository Repository object.
	 */
	protected $repository;

	/**
	 * Class constructor.
	 *
	 * @since 3.0.0
	 *
	 * @param \Required\Traduttore\Repository $repository Repository instance.
	 */
	public function __construct( Repository $repository ) {
		$this->repository = $repository;
	}

	/**
	 * Returns the path to where the Git repository should be checked out.
	 *
	 * @since 3.0.0
	 *
	 * @return string Git repository path.
	 */
	public function get_local_path(): string {
		return sprintf(
			'%1$straduttore-%2$s-%3$s',
			get_temp_dir(),
			$this->repository->get_host(),
			sanitize_title( $this->repository->get_name() )
		);
	}

	/**
	 * Returns the local project path (for monorepos).
	 *
	 * @since 3.1.0
	 *
	 * @return string Project path.
	 */
	public function get_project_path(): string {
		$project_path = $this->get_local_path();
		$filepath     = $this->repository->get_filepath();

		if ( $filepath ) {
			$project_path = trailingslashit( $project_path ) . $filepath;
		}

		return $project_path;
	}
}
