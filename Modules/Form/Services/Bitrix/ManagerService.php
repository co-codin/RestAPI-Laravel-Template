<?php


namespace Modules\Form\Services\Bitrix;

use Illuminate\Support\Collection;
use Medeq\Bitrix24\Models\User\User;
use Modules\Form\Repositories\Contracts\DepartmentRepository;
use Modules\Form\Repositories\Contracts\ManagerRepository;

/**
 * Class ManagerService
 * @package Modules\Form\Services\Bitrix
 * @property DepartmentRepository $departmentRepository
 * @property ManagerRepository $managerRepository
 * @property int $salesDepartmentId
 * @property array|Collection $departments
 * @property array|Collection $users
 * @property array|Collection $bots
 * @property string $botPost
 */
class ManagerService {

    /**
     * @var int ID отдела продаж
     */
    protected $salesDepartmentId = 5;

    /**
     * @var array|Collection|null Хранение всех подотделов Отдела продаж
     */
    protected $departments;

    /**
     * @var array|Collection|null Хранение всех реальных сотрудников из отдела продаж (не боты)
     */
    protected $users;

    /**
     * @var array|Collection|null Хранение всех ботов из отдела продаж (проданные, выигранные, маркетинг греет и т.д.)
     */
    protected $bots;

    /**
     * @var DepartmentRepository
     */
    private $departmentRepository;
    /**
     * @var ManagerRepository
     */
    private $managerRepository;

    /**
     * ManagerService constructor.
     * @param DepartmentRepository $departmentRepository
     * @param ManagerRepository $managerRepository
     */
    public function __construct(
        DepartmentRepository $departmentRepository,
        ManagerRepository $managerRepository
    )
    {
        $this->departmentRepository = $departmentRepository;
        $this->managerRepository = $managerRepository;
    }

    public function getBotIds(): Collection
    {
        return $this->getBots()->pluck('id');
    }

    public function getBots(): Collection
    {
        if (!is_null($this->bots)) {
            return $this->bots;
        }

        return $this->bots = $this->getUsers()->filter(function (User $user) {
            return $user->isBot();
        });
    }

    /**
     * @return Collection
     */
    public function getUsers()
    {
        if (!is_null($this->users))
        {
            return $this->users;
        }

        return $this->users = $this->managerRepository->getManagersByDepartmentIds(
                $this->getSaleDepartments()->pluck('id')->toArray()
            )
            ->keyBy('id');
    }

    public function getRealUserIds() : Collection
    {
        return $this->getUsers()
            ->filter(function (User $user) {
                return ! $user->isBot();
            })
            ->pluck('id');
    }

    /**
     * @return Collection
     */
    public function getSaleDepartments(): Collection
    {
        if (!is_null($this->departments)) {
            return $this->departments;
        }

        $departments = $this->departmentRepository->findAll();

        return $this->departments = $this->getAllChildDepartments(
            $departments, config('bitrix24.sales_department_id')
        );
    }

    public function getUserIds(): Collection
    {
        return $this->getUsers()->pluck('id');
    }

    protected function getAllChildDepartments(Collection $departments, $parent = null) : Collection
    {
        $out = collect([]);

        $out->add(
            $departments->where('id', $parent)->first()
        );

        foreach ($departments as $department) {
            if($department->parent == $parent) {
                $out = $out->merge($this->getAllChildDepartments($departments, $department->id));
            }
        }

        return $out;
    }
}
