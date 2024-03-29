<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\WebPages\Models;

use Callcocam\Tenant\BelongsToTenants;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageWidgetStatItem extends Model
{
    use HasUlids, BelongsToTenants, SoftDeletes, HasFactory;

    protected $guarded = ['id'];

    protected $keyType = 'string';

    public $incrementing = false;
}
