<?php

namespace Database\Factories;

use App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'employee_code'             => 'emp' . $this->faker->randomNumber(3),
            'employee_first_name'       => $this->faker->firstName,
            'employee_last_name'        => $this->faker->lastName(),
            'employee_phone_no'         => $this->faker->phoneNumber(),
        ];
    }
}
