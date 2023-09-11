<?php

namespace App\Http\Services;

use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Repositories\StudentRepository as Student;

class StudentService extends BaseService {

    public function __construct(
        private Student $student,
        private UserService $userService,
        private InstitutionService $institutionService,
    ) {
        parent::__construct($student, 'student');
    }

    public function register(array $payload, string $institutionUrl): array {
        $parsedUrl = parse_url($institutionUrl);
        $alias = explode('.', $parsedUrl['path'])[0]; //* THIS WOULD CHANGE IN PRODUCTION

        $institution = $this->institutionService->findOne(['alias' => $alias]);
        $payload['institution_id'] = $institution->id;

        $user =  DB::transaction(function () use ($payload) {
            $user = $this->userService->create($payload);
            $payload['user_id'] = $user->id;

            $this->student->create($payload);
            return $user;
        });

        $token = $this->generateToken($user->uuid);

        $data = ['user' => $user, 'verification_token' => $token];
        Mail::to($user)->send(new VerificationEmail($user, $token));

        return $data;
    }
}
