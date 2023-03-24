<?php

use App\Models\Pilot;
use Carbon\Carbon;

use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v1/pilots')
        ->assertStatus(302);
});

it('can return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/pilots')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

it('can return an error response', function() {
    $this->actingAs(sanctumToken())->get('v1/pilots?emp=2244')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});

it('can return an collection response', function() {
    $pilotOne = Pilot::factory()->create(['seniority_number' => 1, 'employee_number' => 450765]);
    $pilotTwo = Pilot::factory()->create(['seniority_number' => 2, 'employee_number' => 450766]);

    $this->actingAs(sanctumToken())->get('v1/pilots')
        ->assertExactJson(['data' => [
            [
                'seniority_number' => $pilotOne->seniority_number, 
                'employee_number' => $pilotOne->employee_number, 
                'doh' => Carbon::parse($pilotOne->doh)->format('m/d/Y'), 
                'seat' => $pilotOne->seat, 
                'fleet' => $pilotOne->fleet, 
                'domicile' => $pilotOne->domicile, 
                'retire' => Carbon::parse($pilotOne->retire)->format('m/d/Y'),
                'active' => $pilotOne->active ? 1 : 0, 
                'month' => Carbon::parse($pilotOne->month)->format('M Y'),
            ],
            [
                'seniority_number' => $pilotTwo->seniority_number, 
                'employee_number' => $pilotTwo->employee_number, 
                'doh' => Carbon::parse($pilotTwo->doh)->format('m/d/Y'), 
                'seat' => $pilotTwo->seat, 
                'fleet' => $pilotTwo->fleet, 
                'domicile' => $pilotTwo->domicile, 
                'retire' => Carbon::parse($pilotTwo->retire)->format('m/d/Y'),
                'active' => $pilotTwo->active ? 1 : 0, 
                'month' => Carbon::parse($pilotTwo->month)->format('M Y'),
            ],
        ]])
        ->assertOk();
});

it('can return an model response', function() {
    $pilot = Pilot::factory()->create(['employee_number' => 224]);

    $this->actingAs(sanctumToken())->get('v1/pilots?employee_number=224')
        ->assertExactJson(['data' => [
            [
                'seniority_number' => $pilot->seniority_number, 
                'employee_number' => $pilot->employee_number, 
                'doh' => Carbon::parse($pilot->doh)->format('m/d/Y'), 
                'seat' => $pilot->seat, 
                'fleet' => $pilot->fleet, 
                'domicile' => $pilot->domicile, 
                'retire' => Carbon::parse($pilot->retire)->format('m/d/Y'),
                'active' => $pilot->active ? 1 : 0, 
                'month' => Carbon::parse($pilot->month)->format('M Y'),
            ]
        ]])
        ->assertOk();
});

it('can return an model not found response', 
function() {
    Pilot::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/pilots?employee_number=2255')
        ->assertExactJson(['error' => [
            'message' => 'Pilot with employee number 2255 was not found.',
            'type' => 'Illuminate\Database\Eloquent\ModelNotFoundException',
            'code' => 404
        ]])
        ->assertStatus(404);
});