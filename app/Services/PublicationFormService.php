<?php

/**
 * A Service for Common context
 */

namespace App\Services;

use App\Repositories\PublicationFormRepository;
use App\Repositories\PublicationFormVersionRepository;
use Illuminate\Support\Facades\Log;

/**
 * [Description CommonService]
 */
class PublicationFormService
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

	private PublicationFormRepository $publicationFormRepo;
	private PublicationFormVersionRepository $publicationFormVersionRepo;
	private int $count;
	private mixed $results;

	public function __construct(Log $_logger, PublicationFormRepository $publicationFormRepo, PublicationFormVersionRepository $publicationFormVersionRepo)
    {
        $this->_logger = $_logger;
        $this->loggerDefaultMessage = 'Info';

        $this->publicationFormRepo = $publicationFormRepo;
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
		$this->results = $this->publicationFormRepo
			->getAll($params)
			->makeHidden($hiddenFields)
			->makeVisible($visibleFields);

		$this->count = $this->publicationFormRepo->getCount();

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
		$this->results = $this->publicationFormRepo
			->getByUuid($uuid, $params, $with)
			->makeHidden($hiddenFields)
			->makeVisible($visibleFields);

		return $this->results->toArray();
	}

	public function getAllByFormVersionUuid(
		string $uuid,
		array $params = [],
		array $with = [],
		array $hiddenFields = [],
		array $visibleFields = []
	): array
	{
		$this->results = [];

		$rawResults = $this->publicationFormVersionRepo
			->getByUuid($uuid, $params, $with)
			->makeHidden($hiddenFields)
			->makeVisible($visibleFields);

		dd('rawResults', $rawResults);

		return $this->results->toArray();
	}

}
