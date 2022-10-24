<?php
/**
 * Git URL
 *
 * @since 3.1.0
 */

namespace Required\Traduttore;

/**
 * Git URL class.
 *
 * @since 3.1.0
 */
class GitUrl {
	/**
	 * The repository ref.
	 *
	 * @since 3.1.0
	 *
	 * @var string
	 */
	public string $ref;

	/**
	 * The repository owner.
	 *
	 * @since 3.1.0
	 *
	 * @var string
	 */
	public string $owner;

	/**
	 * The repository name.
	 *
	 * @var string
	 */
	public string $name;

	/**
	 * A filepath relative to the repository root.
	 *
	 * @since 3.1.0
	 *
	 * @var string
	 */
	public string $filepath;

	/**
	 * The owner and name values in the `owner/name` format.
	 *
	 * @since 3.1.0
	 *
	 * @var string
	 */
	public string $full_name;
}
