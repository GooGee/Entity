
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(@echo($factory->model->name)::class, function (Faker $faker) {
    return [
@foreach($factory->fieldList as $field)
@if('property' == $field->type)
        '@echo($field->name)' => $faker->@echo($field->property),
@else
        '@echo($field->name)' => $faker->@echo($field->method)(@echo($field->parameters)),
@endif
@endforeach
    ];
});
