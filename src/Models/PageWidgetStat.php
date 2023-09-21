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

class PageWidgetStat extends Model
{
    use HasUlids, BelongsToTenants, SoftDeletes, HasFactory;

    protected $guarded = ['id'];

    protected $keyType = 'string';

    public $incrementing = false;

    public function page_widget()
    {
        return $this->belongsTo(PageWidget::class);
    }

    public function page_widget_stat_items()
    {
        return $this->hasMany(PageWidgetStatItem::class);
    }
}
