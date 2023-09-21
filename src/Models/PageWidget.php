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

class PageWidget extends Model
{
    use HasUlids, BelongsToTenants, SoftDeletes;

    protected $guarded = ['id'];

    protected $keyType = 'string';

    public $incrementing = false;

    public function pages()
    {
        return $this->belongsToMany(Page::class);
    }

    public function page_widget_stats()
    {
        return $this->hasMany(PageWidgetStat::class);
    }
}
