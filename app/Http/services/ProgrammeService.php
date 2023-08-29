<?php

namespace App\Http\Services;

use App\Repositories\ProgrammeRepository;
use Illuminate\Database\Eloquent\Collection;

class ProgrammeService extends BaseService {

    public function __construct(
        private ProgrammeRepository $programme,
        private InstitutionService $institutionService,
        private FacultyService $facultyService,
    ) {
        parent::__construct($programme, 'programme');
    }

    public function findInstitutionProgrammes(string $institutionId): Collection {
        $this->institutionService->findById($institutionId);

        $programmes = $this->programme->whereHas('department.faculty.institution', function ($query) use ($institutionId) {
            $query->where('id', $institutionId);
        })->get();

        return $programmes;
    }

    public function findFacultyProgrammes(string $facultyId): Collection {
        $this->facultyService->findById($facultyId);

        $programmes = $this->programme->whereHas('department.faculty', function ($query) use ($facultyId) {
            $query->where('id', $facultyId);
        })->get();

        return $programmes;
    }
}
