<?php

namespace App\Models;

use \App\Model;
use Tanmo\Search\Traits\Search;
use Illuminate\Database\Eloquent\SoftDeletes;
class Feedback extends Model
{
    //
    use Search;

    protected $table = "feedbacks";


}
