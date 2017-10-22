
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class @echo($data->className) extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('@echo($data->tableName)', function (Blueprint $table) {
@foreach($data->fieldList as $field)
            @echo($field->text)

@endforeach

@foreach($data->indexList as $index)
            @echo($index->text)

@endforeach
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('@echo($data->tableName)');
    }
}
