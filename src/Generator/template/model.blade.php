
namespace @echo($model->nameSpace);

use Illuminate\Database\Eloquent\Model;

class @echo($model->name) extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '@echo($model->table)';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = '@echo($model->primaryKey)';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [@echo($model->fillable)];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [@echo($model->hidden)];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [@echo($model->dates)];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = @echo($model->timestamps);

    public static $rules = [
@foreach($model->ruleList as $rule)
        @echo($rule->text)

@endforeach
    ];

    
@foreach($model->relationList as $relation)
    public function @echo($relation->name)()
    {
        return @echo($relation->text)

    }

@endforeach

}
