<?php

/**
 * A Service for Common context
 */

namespace App\Services;

use App\Models\PublicationTypeModel;
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
	private CommonService $commonSvc;
	private int $count;
	private mixed $results;

	public function __construct(Log $_logger, PublicationFormVersionRepository $publicationFormVersionRepo, CommonService $commonSvc)
    {
        $this->_logger = $_logger;
        $this->loggerDefaultMessage = 'Info';

        $this->publicationFormVersionRepo = $publicationFormVersionRepo;
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

	public function create(array $data)
	{
		$this->results = $this->publicationFormVersionRepo->create($data);
		return $this->results;
	}

	public function update(string $uuid, array $data)
	{
		$publicationFormVersion = $this->publicationFormVersionRepo->getByUuid($uuid);

		if (!$publicationFormVersion) {
			throw new \Exception("Publication Form Version is not found..!", 404);
		}

		$this->results = $this->publicationFormVersionRepo->updateById($publicationFormVersion->id, $data);

		return $this->results;
	}

	public function upsert(array $data)
	{
		for ($i=0; $i < count($data); $i++) {
			$data[$i]['id_publication_type'] = PublicationTypeModel
				::where('uuid', $data[$i]['uuid_publication_type'])
				->first()->id
			?? null; // Set Publication Type ID property
			unset($data[$i]['uuid_publication_type']); // Removed old Publication Type UUID property

			$uuidCondition = (isset($data[$i]['uuid']) && !empty($data[$i]['uuid']));
			$data[$i]['id'] = ($uuidCondition)
				? $this->publicationFormVersionRepo->getByUuid($data[$i]['uuid'])->id
				: $this->commonSvc->createIDTimestamp(); // If UUID is not found, then make one
			$data[$i]['uuid'] = ($uuidCondition)
				? $data[$i]['uuid']
				: $this->commonSvc->createUUID(); // If ID is not found, then make one
		}

		$this->results = $this->publicationFormVersionRepo->upsert($data);

		return $this->results;
	}

}
