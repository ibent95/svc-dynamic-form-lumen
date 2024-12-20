<?php

/**
 * A Service for Common context
 */

namespace App\Services;

use App\Models\PublicationTypeModel;
use App\Repositories\PublicationGeneralTypeRepository;
use Illuminate\Support\Facades\Log;

/**
 * [Description CommonService]
 */
class PublicationGeneralTypeService
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

	private PublicationGeneralTypeRepository $publicationGeneralTypeRepo;
	private CommonService $commonSvc;
	private int $count;
	private mixed $results;

	public function __construct(Log $_logger, PublicationGeneralTypeRepository $publicationGeneralTypeRepo, CommonService $commonSvc)
    {
        $this->_logger = $_logger;
        $this->loggerDefaultMessage = 'Info';

        $this->publicationGeneralTypeRepo = $publicationGeneralTypeRepo;
        $this->commonSvc = $commonSvc;

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
		$this->results = $this->publicationGeneralTypeRepo
			->getAll($params)
			->makeHidden($hiddenFields)
			->makeVisible($visibleFields);

		$this->count = $this->publicationGeneralTypeRepo->getCount();

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
		$this->results = $this->publicationGeneralTypeRepo
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
		$this->results = $this->publicationGeneralTypeRepo
			->getByUuid($uuid, $params, $with)
			->makeHidden($hiddenFields)
			->makeVisible($visibleFields);

		return $this->results->toArray();
	}

	public function create(array $data)
	{
		$this->results = $this->publicationGeneralTypeRepo->create($data);
		return $this->results;
	}

	public function update(string $uuid, array $data)
	{
		$publicationGeneralType = $this->publicationGeneralTypeRepo->getByUuid($uuid);

		if (!$publicationGeneralType) {
			throw new \Exception("Publication Form Version is not found..!", 404);
		}

		$this->results = $this->publicationGeneralTypeRepo->updateById($publicationGeneralType->id, $data);

		return $this->results;
	}

	public function upsert(array $data)
	{
		for ($i=0; $i < count($data); $i++) {
			$uuidCondition = (isset($data[$i]['uuid']) && !empty($data[$i]['uuid']));
			$data[$i]['id'] = ($uuidCondition)
				? $this->publicationGeneralTypeRepo->getByUuid($data[$i]['uuid'])->id
				: $this->commonSvc->createIDTimestamp(); // If UUID is not found, then make one
			$data[$i]['uuid'] = ($uuidCondition)
				? $data[$i]['uuid']
				: $this->commonSvc->createUUID(); // If ID is not found, then make one
		}

		$this->results = $this->publicationGeneralTypeRepo->upsert($data);

		return $this->results;
	}

}
