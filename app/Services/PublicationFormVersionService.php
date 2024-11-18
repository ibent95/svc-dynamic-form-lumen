<?php

/**
 * A Service for Common context
 */

namespace App\Services;

use App\Repositories\PublicationFormVersionRepository;
use Illuminate\Support\Facades\Log;

/**
 * [Description CommonService]
 */
class PublicationFormVersionService
{

	/**
	 * Log object
	 *
	 * @var object
	 */
	private $_logger;

	/**
	 * [Description for $loggerDefaultMessage]
	 *
	 * @var [type]
	 */
	private $loggerDefaultMessage;

	private PublicationFormVersionRepository $publicationFormVersionRepo;
	private int $count;
	private mixed $results;

	public function __construct(Log $_logger, PublicationFormVersionRepository $publicationFormVersionRepo)
    {
        $this->_logger = $_logger;
        $this->loggerDefaultMessage = 'Info';

        $this->publicationFormVersionRepo = $publicationFormVersionRepo;

		$this->count = 0;
		$this->results = null;
    }

	public function getCount(): int
	{
		return $this->count;
	}

	public function getAll(
		array $params = [],
		array $hiddenFields = [],
		array $visibleFields = []
	): array
	{
		$this->results = $this->publicationFormVersionRepo
			->getAll($params)
			->makeHidden($hiddenFields)
			->makeVisible($visibleFields);

		$this->count = $this->publicationFormVersionRepo->getCount();

		return $this->results->toArray();
	}

	public function getFormsByUuid(
		string $uuid,
		array $params = [],
		array $with = [],
		array $hiddenFields = [],
		array $visibleFields = []
	): array
	{
		$this->results = $this->publicationFormVersionRepo
			->getByUuid($uuid, $params, [...$with, 'publicationForms'])
			->publicationForms
			->makeHidden($hiddenFields)
			->makeVisible($visibleFields);

		$this->count = $this->results->count();

		return $this->results->toArray();
	}

	public function getOne(
		string $uuid,
		array $params = [],
		array $with = [],
		array $hiddenFields = [],
		array $visibleFields = []
	): array
	{
		$this->results = $this->publicationFormVersionRepo
			->getByUuid($uuid, $params, $with)
			->makeHidden($hiddenFields)
			->makeVisible($visibleFields);

		return $this->results->toArray();
	}

}
