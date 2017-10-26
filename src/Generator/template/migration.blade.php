
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class @echo($migration->className) extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('@echo($migration->tableName)', function (Blueprint $table) {
@foreach($migration->fieldList as $field)
            @echo($field->text)

@endforeach

@foreach($migration->indexList as $index)
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
        Schema::dropIfExists('@echo($migration->tableName)');
    }
}
