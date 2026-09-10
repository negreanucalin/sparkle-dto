# Sparkle DTO

Small, dependency-light Data Transfer Objects for PHP, inspired by Laravel's Eloquent attribute conventions. Feed it an array (a request body, a DB row, an API response) and get back a typed, predictable object.

## Install

```bash
composer require negreanucalin/sparkle-dto
```

Requires PHP 7.1.8+ or 8.x. The only runtime dependency is `nesbot/carbon` for date casting.

## Quick start

```php
use SparkleDto\DataTransferObject;

class UserDto extends DataTransferObject
{
    protected $casts = [
        'id'         => 'int',
        'active'     => 'bool',
        'created_at' => 'datetime',        // becomes a Carbon instance
        'address'    => AddressDto::class, // nested DTO
        'roles'      => RoleDto::class,    // list of DTOs (numeric keys)
    ];

    protected $alias = ['first_name' => 'name']; // rename incoming keys

    protected $hidden = ['password']; // readable, but left out of JSON/toString

    // Computed property: available as $dto->full_name
    public function getFullNameAttribute(): string
    {
        return $this->name . ' ' . $this->surname;
    }
}

$user = new UserDto($request->all());

$user->id;            // int
$user->created_at;    // Carbon
$user->address->city; // AddressDto
$user->full_name;     // computed
json_encode($user);   // hidden fields excluded
```

## Features

- **Casting** to `int`, `float`, `bool`, `string`, `array`, `date`/`datetime` (Carbon), or another DTO class.
- **Custom casts** via a static callable: `'flag' => [MyDto::class, 'castYesNo']`. The method receives the value and the full input array.
- **Nested DTOs and lists.** A cast to a DTO class hydrates a single object or a list, depending on the input shape. Add `*` to the key (`'users*'`) to keep string keys and get a map instead.
- **Computed attributes.** Any `getXxxAttribute()` method becomes a snake_case property (`getFullNameAttribute` → `full_name`). Recomputed when you set a property.
- **Aliases** rename incoming keys before anything else runs.
- **`$hidden`** keeps a value accessible on the object but out of serialization. **`$fillable`** whitelists which keys are accepted. Use one or the other, not both.
- **`$dates`** marks extra fields to convert to Carbon without listing them in `$casts`.
- Implements `ArrayAccess` and `JsonSerializable`; `(string) $dto` gives JSON.
- `MyDto::hydrate($rows)` builds a list of DTOs from a list of arrays.
- `DataTransferObjectWithId` adds a random hex `id` computed attribute.

## Tests

```bash
composer test
```

## License

MIT
