# Laravel Model Logs

The laravel-model-logs package provides an easy way to track changes made to your Eloquent models and log them into an `audit_logs` table. It allows you to keep a history of all the modifications made to your models, making it useful for auditing purposes, user activity tracking, and more.

## Installation

You can install the package via Composer by running the following command:

```bash
composer require asif/laravel-model-logs
```

After installing the package, Laravel will automatically discover the service provider.

## Usage

### Step 1: Set up the Database

Before using the package, you need to create the audit_logs table in your database. You can use the provided migration file to create the table by running the migration:

```bash
php artisan migrate

```

### Step 2: Add the LogChanges Trait to Your Models

To start tracking changes on your models, add the LogChanges trait to each model you want to monitor. The trait provides the necessary functionality to automatically log changes whenever the model is created, updated, or deleted.

```php
use Asif\LaravelModelLogs\Traits\LogChanges;
use Illuminate\Database\Eloquent\Model;

class YourModel extends Model
{
    use LogChanges;

    // Rest of your model code...
}

```

### Step 3: Customize Tracked Events (Optional)

By default, the LogChanges trait tracks all events: 'created', 'updated', and 'deleted'. However, you can customize the tracked events for each model by adding a $trackedEvents property to the model. If the property is not defined, the package will track all events.

```php
use Asif\LaravelModelLogs\Traits\LogChanges;
use Illuminate\Database\Eloquent\Model;

class YourModel extends Model
{
    use LogChanges;

    /**
     * Customize the tracked events for this model.
     *
     * @var array<string>
     */
    protected $trackedEvents = ['created', 'updated'];

    // Rest of your model code...
}
```

### Step 4: Define Loggable Fields (Optional)

You can further customize the fields that should be logged for each model by adding a $loggable property to the model, containing an array of field names that you want to track. If the property is not provided, the package will log all the fields.

```php
use Asif\LaravelModelLogs\Traits\LogChanges;
use Illuminate\Database\Eloquent\Model;

class YourModel extends Model
{
    use LogChanges;

    /**
     * The attributes that should be logged in the audit log.
     *
     * @var array<string>
     */
    protected $loggable = ['name', 'email'];

    // Rest of your model code...
}
```

## License

The laravel-model-logs package is open-sourced software licensed under the MIT License.
