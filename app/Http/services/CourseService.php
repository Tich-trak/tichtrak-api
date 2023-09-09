<?php

namespace App\Http\Services;


use ErrorException;
use App\Imports\CourseImports;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\CourseRepository;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\Uid\Ulid;

class CourseService extends BaseService {

    public function __construct(
        private CourseRepository $course,
        private InstitutionService $institutionService,
        private FacultyService $facultyService,
        private LevelService $levelService,
        private DepartmentService $departmentService
    ) {
        parent::__construct($course, 'course');
    }


    public function bulkInsert(array $request) {
        if (!$request['file']) throw new ErrorException('excel file cannot be empty');

        $data = Excel::toArray(new CourseImports, $request['file'])[0];
        $level = $this->levelService->findById($data[0]['level_id']);

        $payload = collect($data);

        $payload = $payload->map(function ($data) use ($level) {
            $data['id'] = Ulid::generate();
            $data['level_id'] = $level->id;

            return $data;
        });

        return $this->course->bulkCreate($payload->toArray());
    }

    public function findInstitutionCourses(string $institutionId): Collection {
        $this->institutionService->findById($institutionId);

        $courses = $this->course->whereHas('level.institution', function ($query) use ($institutionId) {
            $query->where('id', $institutionId);
        })->get();

        return $courses;
    }

    public function findFacultyCourses(string $facultyId): Collection {
        $this->facultyService->findById($facultyId);

        $courses = $this->course->whereHas('level.institution.faculties', function ($query) use ($facultyId) {
            $query->where('id', $facultyId);
        })->get();

        return $courses;
    }

    public function findDepartmentCourses(string $departmentId): Collection {
        $this->departmentService->findById($departmentId);

        $courses = $this->course->whereHas('departments', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })->get();

        return $courses;
    }
}