<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\WebPages\Models;

use Callcocam\Tenant\BelongsToTenants;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $slug
 * @property string $name 
 * @property string $description
 * @property string $icon
 * @property int $ordering
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class PageGroup extends Model
{
    use HasUlids, BelongsToTenants, SoftDeletes;

    protected $guarded = ['id'];

    protected $keyType = 'string';

    public $incrementing = false;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
 
    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
