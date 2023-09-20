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
 * @property string $page_group_id
 * @property string $slug
 * @property string $singular_name
 * @property string $plural_name
 * @property string $description
 * @property string $icon
 * @property int $ordering
 * @property array{content: array, template: string, templateName: string} data
 * @property \Carbon\CarbonImmutable $published_at
 * @property \Carbon\CarbonImmutable $published_until
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Page extends Model
{
    use HasUlids, BelongsToTenants, SoftDeletes;

    protected $guarded = ['id'];

    protected $keyType = 'string';

    public $incrementing = false;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $casts = [
        'blocks' => 'json',
        'data' => 'json',
        'published_at' => 'immutable_datetime',
        'published_until' => 'immutable_datetime',
    ];

    public function pageGroup()
    {
        return $this->belongsTo(PageGroup::class);
    }
}
